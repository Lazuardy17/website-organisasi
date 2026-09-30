<?php

namespace App\Modules\Landing\Controllers;

use App\Controllers\BaseController;

class LandingController extends BaseController
{
    public function index()
    {
        return view('App\Modules\Landing\Views\index');
    }
}