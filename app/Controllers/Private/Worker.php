<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\WorkerModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Shield\Controllers\RegisterController;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\GroupModel;
use CodeIgniter\Shield\Validation\ValidationRules;
use CodeIgniter\Validation\Exceptions\ValidationException;
use Config\AuthGroups;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class Worker extends BaseController
{
    private $db;

    public function __construct(
        private $workerModel = new WorkerModel(),
        private $userModel = new UserModel(),
        private $groupModel = new GroupModel(),
    ) {
        $this->db = \Config\Database::connect();
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

        $data = $this->workerModel->getUser($search, $perPage, $page);

        $data['topbarData'] = [
            'title' => 'List Worker',
            'desc' => 'List Of Worker Account And Personal Data'
        ];

        return view('pages/Private/Worker/IndexWorker', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($idEncrypt = null)
    {

        $id = decrypt_url($idEncrypt);

        $data['topbarData'] = [
            'title' => 'List Worker',
            'desc' => 'List Of Worker Account And Personal Data'
        ];
        $data['role'] = (new AuthGroups)->groups;
        return PrivatePages('Worker/DetailWorker', $data);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {

        $data['topbarData'] = [
            'title' => 'Add Worker',
            'desc' => 'Make An account For Worker'
        ];

        $data['role'] = (new AuthGroups)->groups;


        return view('pages/Private/Worker/AddWorker', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $users = $this->userModel;

        $rules = $this->getValidationRules();


        if (!$this->validateData($this->request->getPost(), $rules, []) || !$this->validateData($this->request->getPost(), $this->workerModel->getValidationRules())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();

        $getPost = array_merge(
            $this->request->getPost($allowedPostFields),
            ['avatar' => _imageUpload($this->request, 'avatar', savePath: 'upload/avatars/', fileNameOld: null)]
        );

        $user->fill($getPost);

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        try {
            $this->db->transException(true)->transStart();

            $users->save($user);

            $user = $this->userModel->find($users->getInsertID());

            $qrData = [
                'nik' => $this->request->getPost('nik'),
                'email' => $user->email,
                'username' => $user->username,
                'shift' => $this->request->getPost('shift')
            ];

            $qrCodeRes = generateQRCode($qrData, $user->avatar ? 'upload/avatars/' . $user->avatar : 'upload/avatars/default.jpg', $user->username);

            // Add to default group
            $this->workerModel->save([
                'nik' => $this->request->getPost('nik'),
                'shift' => $this->request->getPost('shift'),
                'user_id' => $users->getInsertID(),
                'qr_code' => $qrCodeRes->getDataUri()
            ]);

            if ($this->request->getPost('role')) {
                $this->groupModel->insert([
                    'user_id' => $users->getInsertID(),
                    'group' => $this->request->getPost('role'),
                ]);
            } else {
                $this->groupModel->insert([
                    'user_id' => $users->getInsertID(),
                    'group' => 'worker',
                ]);
            }

            $this->db->transComplete();
            // $i['avatar'] = _imageUpload($this->request, 'avatar', savePath: 'upload/avatars/', fileNameOld: null);
            // $this->userModel->update($users->getInsertID(), $i);
        } catch (DatabaseException $e) {
            _imageDelete($this->request->getPost('avatar'), 'upload/avatar/');
            return redirect()->back()->withInput()->with('errors', 'There Something Wrong, Please Inform Admin');
        }

        return redirect()->back()->with('success', 'New Worker successful Saved');
    }

    protected function getValidationRules(): array
    {
        $rules = new ValidationRules();
        return $rules->getRegistrationRules();
    }

    protected function getUserProvider(): UserModel
    {
        $provider = model(setting('Auth.userProvider'));

        assert($provider instanceof UserModel, 'Config Auth.userProvider is not a valid UserProvider.');

        return $provider;
    }

    protected function getUserEntity(): User
    {
        return new User();
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
}
