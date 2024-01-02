<?php

namespace App\Controllers\LandingPages;

use App\Controllers\BaseController;

class Park extends BaseController
{
    public function information()
    {
        $data['topbar'] = [
            'title' => 'Information About Wild Life Park',
            'description' => 'Information'
        ];
        return LandingPages('Park/Information', $data);
    }
}
