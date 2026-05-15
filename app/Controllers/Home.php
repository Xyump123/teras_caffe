<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function landing()
    {
    return redirect()->to('/admin/login');
    }
}