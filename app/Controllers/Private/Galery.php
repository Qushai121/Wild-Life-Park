<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Models\GaleryModel;
use CodeIgniter\RESTful\ResourceController;

class Galery extends BaseController
{

    public function __construct(
        public $galeryModel = new GaleryModel()

    ) {

        if (!auth()->user()->inGroup('superadmin','dataentry')) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        };
        // auth()->user()->addGroup('dataentry');
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

        $data = $this->galeryModel->getPaginate_Search($search, $perPage, $page);

       
        $data['topbarData'] = [
            'title' => 'Galery',
            'desc' => 'List Galery'
        ];


        return view('pages/Private/Galery/IndexGalery', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        // auth()->user()->can('admin.access');
        $data['topbarData'] = [
            'title' => 'Galery',
            'desc' => 'Add More Galery'
        ];

        return view('pages/Private/Galery/AddGalery', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = [
            'title' =>  $this->request->getPost('title'),
            'description' =>  $this->request->getPost('description'),
            'type' =>  $this->request->getPost('type'),
            'images' => _imageUpload($this->request, 'images', null, 'upload/galerys/'),
        ];

        $responses = $this->galeryModel->insert($data);

        if (!$responses) {
            return redirect()->back()->withInput()->with('errors', $this->galeryModel->errors());
        }

        return redirect()->back()->with('message', 'Galery Saved SuccessFully');
    }

    // /**
    //  * Return the editable properties of a resource object
    //  *
    //  * @return mixed
    //  */
    // public function edit($id = null)
    // {
    //     $listGalery = $this->galeryModel->find($id);

    //     // Assuming you have other data you want to send back, you can include it in the $data array
    //     $data['html'] =  pages('Private/Galery/editGalery', ['key' => $id, 'listGalery' => $listGalery]);
    //     // Add more data as needed


    //     // Return data as JSON
    //     return $this->response->setJSON($data);
    // }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $data = [
            'title' =>  $this->request->getPost('title'),
            'description' =>  $this->request->getPost('description'),
            'type' =>  $this->request->getPost('type'),
            'images' => _imageUpload($this->request, 'images', 'imagesOld', 'upload/galerys/'),
        ];
        $responses = $this->galeryModel->update($id, $data);

        if (!$responses) {
            return redirect()->back()->withInput()->with("errors$id", $this->galeryModel->errors());
        }

        return redirect()->back()->with('success', 'Galery Edit SuccessFully');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = $this->galeryModel->find($id);
        $resImage = _imageDelete($data['images'], 'upload/galerys/');
        if ($resImage) {
            $this->galeryModel->delete($id);
            return redirect()->back()->with('error', 'Galery Delete Failed');
        }
        
        return redirect()->back()->with('success', 'Galery Delete SuccessFully');
    }
}
