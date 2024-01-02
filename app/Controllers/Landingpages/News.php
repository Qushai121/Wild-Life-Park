<?php

namespace App\Controllers\LandingPages;

use App\Controllers\BaseController;
use App\Models\NewsModel;
use DateTime;

class News extends BaseController
{
    public function __construct(
        private $newsModel  = new NewsModel()
    ) {
    }
    public function index()
    {
        $currentDateTime = new DateTime();
        $nowTime = $currentDateTime->format('Y-m-d');
        $search = $this->request->getGet('search');
        $page = $this->request->getGet('page');
        $time = $this->request->getGet('time');

        $data = $this->newsModel->getPaginateSearchAllPublished($search, 20, $page,$time);
        
        $data['nowTime'] = $nowTime;
        $data['topbar'] = [
            'title' => 'News / Event About Wild Life Park',
            'description' => 'Find All New News About Wild Life Park'
        ];
        return LandingPages('News/IndexNews', $data);
    }

    public function detail($idEncrypt)
    {
        $id = decrypt_url($idEncrypt);

        
        $data['newsData'] = $this->newsModel->getByIdJoinUsers($id);
        $data['cardNewsDatas'] = $this->newsModel->getForCardWhereNotId([$id]);
        
                $data['topbar'] = [
                    'title' => 'Detail News / Event In Wild Life Park',
                    'description' => $data['newsData']['title']
                ];

        if (empty($data['newsData'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Page Not Found');
        };

        return LandingPages('News/DetailNews', $data);
    }
}
