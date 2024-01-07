<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    
    public function login()
    {
        return pages('auth/Login');
    }

    public function register()
    {
        
        return view('templates/LandingPages');
    }
}
