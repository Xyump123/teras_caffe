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

        // Ambil file foto
        $file = $this->request->getFile('foto');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Buat folder uploads jika belum ada
            $uploadPath = FCPATH . 'uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            // Hapus foto lama jika ada
            $oldUser = $this->db->table('users')
                ->where('id', session('user_id'))
                ->get()
                ->getRowArray();
                
            if ($oldUser && $oldUser['foto'] && file_exists($uploadPath . $oldUser['foto'])) {
                unlink($uploadPath . $oldUser['foto']);
            }

            // Upload foto baru
            $namaFile = $file->getRandomName();
            $file->move($uploadPath, $namaFile);
            $data['foto'] = $namaFile;
        }

        // Update ke database
        $this->db->table('users')
            ->where('id', session('user_id'))
            ->update($data);

        // Update session dengan data baru
        $sessionData = [
            'nama'  => $data['nama'],
            'email' => $data['email'],
            'bio'   => $data['bio'],
        ];
        
        if (isset($data['foto'])) {
            $sessionData['foto'] = $data['foto'];
        }
        
        $this->session->set($sessionData);

        return redirect()->to('/admin/profile')->with('success', 'Profile berhasil diupdate');
    }
}