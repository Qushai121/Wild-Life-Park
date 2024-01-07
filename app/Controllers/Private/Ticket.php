<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Enums\Worker;
use App\Models\TicketManagementModel;
use App\Models\TicketModel;
use App\Models\TicketQrCodeModel;
use DateTime;

class Ticket extends BaseController
{

    public function __construct(
        private $ticketModel = new TicketModel(),
        private $ticketQrCodeModel = new TicketQrCodeModel(),
        private $ticketMagementModel = new TicketManagementModel(),
    ) {
    }
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {

        $perPage = $this->request->getGet('perPage') ?: 10;
        $page = $this->request->getGet('page');
        $search = $this->request->getGet('search');

        $data = $this->ticketModel->getPaginate_Search($search, $perPage, $page);
        $data['topbarData'] = [
            'title' => 'Ticket',
            'desc' => 'List Ticket'
        ];

        return view('pages/private/ticket/IndexTicket', $data);
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
        $data['topbarData'] = [
            'title' => 'Ticket',
            'desc' => 'Add Ticket'
        ];
        return view('pages/private/ticket/AddTicket', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getPost(
            [
                'name',
                'description',
                'access',
                'discount',
                'price',
                'qty',
                'totalqrcode',
                'publish',
            ]
        );

        $data['image'] = _imageUpload($this->request, 'image', null, 'upload/tickets/');

        $responses = $this->ticketModel->insert($data);

        if (!$responses) {
            return redirect()->back()->withInput()->with('errors', $this->ticketModel->errors());
        }

        return redirect()->back()->with('success', 'Data Saved');
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

        $data = $this->request->getPost(
            [
                'name',
                'description',
                'access',
                'discount',
                'price',
                'qty',
                'totalqrcode',
                'publish',
            ]
        );
        $data['image'] = _imageUpload($this->request, 'image', 'imageOld', 'upload/tickets/');

        $responses = $this->ticketModel->update($id, $data);

        if (!$responses) {
            return redirect()->back()->withInput()->with("errors$id", $this->ticketModel->errors());
        }

        return redirect()->to(base_url('private/ticket'))->with('success', 'Data Saved');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = $this->ticketModel->find($id);
        $resImage = _imageDelete($data['image'], 'upload/ticket/');
        if ($resImage) {
            $this->ticketModel->delete($id);
            return redirect()->back()->withInput();
        }

        return redirect()->back()->withInput();
    }

    public function IndexScan()
    {

        $data['topbarData'] = [
            'title' => 'Scanner Ticket',
            'desc' => 'Scanner For Ticket Guard Scaning Customer E-Ticket'
        ];
        return PrivatePages('Ticket/Scan/IndexScanTicket', $data);
    }

    public function scanUpdateData()
    {
        $reqData = [
            'transaction_id' => $this->request->getVar("transaction_id"),
            'qrcode_token' => $this->request->getVar('qrcode_token'),
            'access' => $this->request->getVar('access'),
        ];

        $dataQrCodeModel = $this->ticketQrCodeModel->getTicketByQrCodeToken($reqData['qrcode_token']);

        if (empty($dataQrCodeModel)) {
            return $this->response->setJSON(['error' => 'Ticket Token Hasnt Found'])->setStatusCode(500);
        }


        $currentDateTime = new DateTime();


        if ($dataQrCodeModel['expired_at'] < $currentDateTime->format('Y-m-d H:i:s') || $dataQrCodeModel['status'] == 'expired') {
            $this->ticketQrCodeModel->update(
                $dataQrCodeModel['id'],
                [
                    'transaction_id' => $dataQrCodeModel['transaction_id'],
                    'status' => 'expired',
                    'qrcode' => $dataQrCodeModel['qrcode'],
                    'qrcode_token' => $dataQrCodeModel['qrcode_token'],
                    'expired_at' => $dataQrCodeModel['expired_at'],
                ]
            );
            return $this->response->setJSON(['error' => "Ticket Already Expired at : $dataQrCodeModel[expired_at]"])->setStatusCode(500);
        }

        if ($dataQrCodeModel['status'] == 'used') {
            return $this->response->setJSON(['error' => "Ticket Already Used "])->setStatusCode(500);
        }


        $this->ticketQrCodeModel->update(
            $dataQrCodeModel['id'],
            [
                'transaction_id' => $dataQrCodeModel['transaction_id'],
                'status' => 'used',
                'qrcode' => $dataQrCodeModel['qrcode'],
                'qrcode_token' => $dataQrCodeModel['qrcode_token'],
                'expired_at' => $dataQrCodeModel['expired_at'],
            ]
        );

        return $this->response->setJSON(['success' => 'Enjoy The Park']);
    }

    public function indexTicketManagement()
    {

        $perPage = $this->request->getGet('perPage') ?: 10;
        $page = $this->request->getGet('page');
        $search = $this->request->getGet('search');

        $data = $this->ticketMagementModel->getPaginateSearch($search, $perPage, $page);

        $data['topbarData'] = [
            'title' => 'Manage Ticket',
            'desc' => 'Manage Ticket Quota Per Day'
        ];

        $data['TicketManagementMain'] = $this->ticketMagementModel->where('status', 'to_all_date')->first();

        return PrivatePages('Ticket/TicketManagement/IndexTicketManagement', $data);
    }

    public function editTicketManagement($idEncrypt = null)
    {
        $id = decrypt_url($idEncrypt);
        $dataReq = $this->request->getPost(['quota_per_day', 'the_day', 'status']);

        $this->ticketMagementModel->save(
            [
                'id' =>  $id,
                'status' => $dataReq['status'] ?: null,
                'quota_per_day' => $dataReq['quota_per_day'] ?: null,
                'the_day' => $dataReq['the_day'] ?: null,
            ]
        );

        return redirect()->back();
    }

    public function addTicketManagement()
    {
        $dataReq = $this->request->getPost(['quota_per_day', 'the_day', 'status']);

        $this->ticketMagementModel->insert($dataReq);

        return redirect()->back();
    }

    public function deleteTicketManagement($idEncrypt = null)
    {
        $id = decrypt_url($idEncrypt);
        $this->ticketMagementModel->delete($id);
        return redirect()->back();
    }
}
