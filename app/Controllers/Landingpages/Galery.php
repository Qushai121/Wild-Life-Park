<?php

namespace App\Controllers\LandingPages;

use App\Controllers\BaseController;
use App\Models\GaleryModel;

class Galery extends BaseController
{
    public function __construct(
        private $galeryModel = new GaleryModel()
    ) {
    }

    public function indexAnimal()
    {
        $perPage = $this->request->getGet('perPage') ?: 10;
        $page = $this->request->getGet('page');
        $search = $this->request->getGet('search');

        $data = $this->galeryModel->getByTypePaginateSearch($search,$perPage,$page,'animal');
      
        $data['topbar'] = [
            'title' => 'Wild Life Park Animal List',
            'description' => 'Find Your Favorite Animal Here'
        ];

        
        return LandingPages('Galery/IndexGaleryAnimal', $data);
    }

    public function indexHuman()
    {
        $perPage = $this->request->getGet('perPage') ?: 10;
        $page = $this->request->getGet('page');
        $search = $this->request->getGet('search');

        $data = $this->galeryModel->getByTypePaginateSearch($search,$perPage,$page,'human');
      
        $data['topbar'] = [
            'title' => 'Wild Life Park Human List',
            'description' => 'Find Your Favorite Human Here'
        ];
        
        return LandingPages('Galery/IndexGaleryHuman', $data);
    }
}
