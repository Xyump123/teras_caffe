<?php

namespace App\Controllers\Menu;

use App\Controllers\BaseController;
use App\Models\MenuModel;

class MenuPelanggan extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function landing()
    {
        return view('landing');
    }

    public function index()
    {
        $menuModel = new MenuModel();
        $meja = $this->request->getGet('meja') ?? 0;

        return view('menu/index', [
            'menu' => $menuModel->findAll(),
            'meja' => $meja
        ]);
    }
}