<?php

namespace App\Controllers\Private;

use App\Controllers\BaseController;
use App\Models\GaleryModel;
use App\Models\NewsModel;
use CodeIgniter\RESTful\ResourceController;

class News extends BaseController
{

    public function __construct(
        private $newsModel = new NewsModel()
        // public $newsModel = new GaleryModel()
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

        $data = $this->newsModel->getPaginateSearchByAuthorId($search, $perPage, $page);

        $data['topbarData'] = [
            'title' => 'News',
            'desc' => 'List Of News'
        ];

        return PrivatePages('News/IndexNews', $data);
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
        $data['topbarData'] = [
            'title' => 'News',
            'desc' => 'List Of News',
        ];
        $data['news'] = $this->newsModel->first();

        return PrivatePages('News/AddNews', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $data = $this->request->getPost(['title', 'publish', 'content', 'background_image']);
        $data['author_id'] = auth()->user()->id;

        $responses =  $this->newsModel->validate($data);

        if (!$responses) {
            return redirect()->back()->withInput()->with('errors', $this->newsModel->errors());
        }

        $data['background_image'] = _imageUpload($this->request, 'background_image', null, 'upload/news/');
        $this->newsModel->skipValidation(true)->insert($data);

        return redirect()->back()->with('success', 'Data Saved');
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($idEncrypt = null)
    {

        $id = decrypt_url($idEncrypt);
        $data['topbarData'] = [
            'title' => 'News',
            'desc' => 'List Of News'
        ];

        $data['news'] = $this->newsModel->find($id);

        if ($data['news']['author_id'] != auth()->user()->id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        }

        return PrivatePages('News/EditNews', $data);
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($idEncrypt = null)
    {
        $id = decrypt_url($idEncrypt);
        $data = $this->request->getPost(['title', 'publish', 'content', 'background_image']);

        $this->validateData(
            $data,
            $this->newsModel->getValidationRules(
                [
                    'only' => [
                        'title',
                        'publish',
                        'content',
                    ],
                ]
            ),
        );

        $data['background_image'] = _imageUpload($this->request, 'background_image', 'background_imageOld', 'upload/news/');

        if ($errorMsg =  $this->validator->getErrors()) {
            return redirect()->back()->withInput()->with("errors", $errorMsg);
        }

        $this->newsModel->skipValidation(true)->where('author_id', auth()->user()->id)->update($id, $data);

        return redirect()->back()->with('success', 'Data Saved');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {

        $data = $this->newsModel->find($id);
        $resImage = _imageDelete($data['background_image'], 'upload/news/');
        if ($resImage) {
            $this->newsModel->where('author_id', auth()->user()->id)->delete($id);
            return redirect()->back()->withInput();
        }

        return redirect()->back()->withInput();
    }
}
