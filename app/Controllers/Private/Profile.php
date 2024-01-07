<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Controllers\Helper;
use App\Models\AbsentModel;
use App\Models\UserModel;
use App\Models\WorkerModel;

class Profile extends BaseController
{
    public function __construct(
        private $userModel = new UserModel(),
        private $workerModel =  new WorkerModel(),
        private $absentModel =  new AbsentModel(),
    ) {
    }

    public function index()
    {

        $data['topbarData'] = [
            'title' => 'Profile',
            'desc' => 'Atur Avatar Dan Password Kamu'
        ];

        $data['worker'] = $this->workerModel->where('user_id', auth()->id())->first();
        $data['absents'] = $this->absentModel->getByIdEmployee(auth()->id());

        return view('Pages/Private/Profile/IndexProfile', $data);
    }


    public function avatarPost()
    {
        $username = $this->request->getPost('username');

        if ($username === auth()->user()->username) {
            $isUnique = '';
        } else {
            $isUnique = 'is_unique[users.username]';
        }

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'username' => [
                'rules' => "required|$isUnique",
                'errors' => [
                    'required' => '{field} Tidak Boleh Kosong',
                    'is_unique' => '{field} Sudah Digunakan',
                ]
            ],
            'avatar' => 'max_size[avatar,1024]',
        ]);


        if (!$valid) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $data = [
            'username' => $username,
            'avatar' => _imageUpload($this->request, 'avatar', 'avatar_old', 'upload/avatars/'),
        ];

        $this->userModel->where('id', auth()->user()->id)->update(auth()->user()->id, $data);

        return redirect()->back()->with('success', 'Profile Saved SuccessFully');
    }

    public function resetPass()
    {
    }

    public function updateMyInfoWorker()
    {
        $myWorkerInfo = $this->workerModel->where('user_id', auth()->id())->first();

        $qrData = [
            'nik' => $this->request->getPost('nik'),
            'email' => auth()->user()->email,
            'username' => auth()->user()->username,
            'shift' => $this->request->getPost('shift')
        ];

        $qrCodeRes = generateQRCode($qrData, "upload/avatars/" . auth()->user()->avatar, auth()->user()->username);

        $this->workerModel->save(
            [
                'id' => $myWorkerInfo ? $myWorkerInfo['id'] : null,
                'nik' => $this->request->getPost('nik') ?: $myWorkerInfo['shift'],
                'shift' => $this->request->getPost('shift') ?: $myWorkerInfo['shift'],
                'user_id' => auth()->id(),
                'qr_code' => $qrCodeRes->getDataUri() ?: $myWorkerInfo['qr_code']

            ]
        );

        // if (!$myWorkerInfo) {
        //     $this->workerModel->save([
        //         'nik' => $this->request->getPost('nik'),
        //         'shift' => $this->request->getPost('shift'),
        //         'user_id' => auth()->id(),
        //         'qr_code' => $qrCodeRes->getDataUri()
        //     ]);
        // } else {
        //     $this->workerModel->update(
        //         $myWorkerInfo['id'],
        //         [
        //             'nik' => $this->request->getPost('nik') ?: $myWorkerInfo['shift'],
        //             'shift' => $this->request->getPost('shift') ?: $myWorkerInfo['shift'],
        //             'user_id' => auth()->id(),
        //             'qr_code' => $qrCodeRes->getDataUri() ?: $myWorkerInfo['qr_code']

        //         ]
        //     );
        // }

        return redirect()->to('private/profile')->with('success',"Updating Your Info Worker SuccessFully");
    }
}
