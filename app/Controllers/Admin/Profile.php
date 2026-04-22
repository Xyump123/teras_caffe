<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Profile extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
    }

    private function checkLogin()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/admin/login')->send();
        }
    }

    public function index()
    {
        $this->checkLogin();
        return view('admin/profile');
    }

    public function edit()
    {
        $this->checkLogin();
        return view('admin/edit_profile');
    }

    public function update()
    {
        $this->checkLogin();

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'bio'   => $this->request->getPost('bio'),
        ];

        $file = $this->request->getFile('foto');

        if ($file && $file->isValid()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads', $namaFile);
            $data['foto'] = $namaFile;
        }

        $this->db->table('users')
            ->where('id', session('user_id'))
            ->update($data);

        $this->session->set($data);

        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }
}