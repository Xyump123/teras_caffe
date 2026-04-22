<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Auth extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
    }

    public function login()
    {
        if ($this->session->get('logged_in')) {
            return redirect()->to('/admin/dashboard');
        }
        return view('admin/login');
    }

    public function loginProcess()
    {
        $username = $this->request->getPost('username');
        $password = trim($this->request->getPost('password'));

        $user = $this->db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        $this->session->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'nama'      => $user['nama'],
            'email'     => $user['email'],
            'foto'      => $user['foto'],
            'bio'       => $user['bio'],
            'role'      => $user['role']
        ]);

        return redirect()->to('/admin/dashboard');
    }

    public function register()
    {
        return view('admin/register');
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
}