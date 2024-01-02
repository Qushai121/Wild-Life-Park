<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Models\AbsentModel;
use App\Models\WorkerModel;
use DateTime;

class Absent extends BaseController
{

    public function __construct(
        private $workerModel =  new WorkerModel(),
        private $absentModel =  new AbsentModel(),
    ) {
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {

        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d');
        $perPage = $this->request->getGet('perPage') ?: 10;
        $page = $this->request->getGet('page');
        $search = $this->request->getGet('search');
        $time = $this->request->getGet('time');

        $data = $this->absentModel->getByTime($search, $perPage, $page, $time);

        $data['nowTime'] = $nowTime;
        $data['topbarData'] = [
            'title' => 'Absent',
            'desc' => 'List Absent'
        ];

        return view('pages/Private/Absent/IndexAbsent', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }


    /**
     * view for absent scanner in admin menu
     **/
    public function indexScan()
    {

        if (!auth()->user()->inGroup('superadmin', 'dataentry')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        };
        $data['topbarData'] = [
            'title' => 'Scanner Absent',
            'desc' => 'Scanner For Worker To Absent'
        ];

        return view('pages/Private/Absent/Scan/IndexScan', $data);
    }

    public function checkWorkerDataScan()
    {

        if (!auth()->user()->inGroup('superadmin', 'dataentry')) {
            return $this->response->setJSON(['error' => 'ONLY Admin / Data Entry Role To Allow Scanning'])->setStatusCode(404);
        };

        $data = [
            'shift' => $this->request->getVar('shift'),
        ];

        $reqData = [
            'nik' => $this->request->getVar("nik"),
            'shift' => $this->request->getVar('shift'),
            'email' => $this->request->getVar('email'),
        ];

        $userData = $this->workerModel->where('nik', $reqData['nik'])->first();
        if (empty($userData)) {
            return $this->response->setJSON(['error' => 'NIK Not Found'])->setStatusCode(404);
        } else {
            $data['employee_id'] = $userData['user_id'];
        };

        function statusAbsent($targetTimes)
        {
            $status = null;

            $currentDateTime = new DateTime();

            $targetTime = new DateTime($targetTimes);
            $nextHour = clone $targetTime;

            if ($currentDateTime >= $targetTime  && $currentDateTime <= $nextHour->modify('+1 hour')) {
                $status = 'Present';
            }
            if ($currentDateTime >= $targetTime && $currentDateTime <= $nextHour->modify('+2 hour')) {
                $status = 'Late';
            }
            if ($currentDateTime < $targetTime) {
                $status = 'To Fast';
            }
            if ($currentDateTime > $nextHour->modify('+2 hour')) {
                $status = 'Absent';
            }

            return $status;
        }

        if ($reqData['shift'] === 'night') {
            $data['status']  = statusAbsent('20:00:00');
        } else {
            $data['status']  = statusAbsent('5:00:00');
        }

        // $currentDateTime = new DateTime();
        // $targetTime = new DateTime('0:00:00');
        // $nextHour = clone $targetTime;
        // $next = $nextHour->modify('+1 hour');
        // return $this->response->setJSON(['error' => $currentDateTime <= $targetTime && $currentDateTime >= $next])->setStatusCode(500);
       
        $todayDate = date('Y-m-d');

        $todayRecords = $this->absentModel
            ->where("DATE(created_at) = '{$todayDate}'")
            ->where('employee_id', $userData['user_id'])
            ->first();


        if (!empty($todayRecords)) {
            return $this->response->setJSON(['error' => 'You Already Absent Today'])->setStatusCode(500);
        }

        $this->absentModel->insert($data);


        return $this->response->setJSON(
            [
                'success' => "Absent Success with Status : $data[status]"
            ]
        )->setStatusCode(200);
    }
}
