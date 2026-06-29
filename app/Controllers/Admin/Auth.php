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

        // Validasi input
        if (empty($username) || empty($password)) {
            return redirect()->back()->with('error', 'Username dan password wajib diisi');
        }

        // Cari user di database
        $user = $this->db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        // ============================================================
        // CEK PASSWORD DENGAN PASSWORD_VERIFY (HASH)
        // ============================================================
        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Set session
        $this->session->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'nama'      => $user['nama'] ?? $user['username'],
            'email'     => $user['email'] ?? '',
            'foto'      => $user['foto'] ?? null,
            'bio'       => $user['bio'] ?? '',
            'role'      => $user['role'] ?? 'admin'
        ]);

        return redirect()->to('/admin/dashboard')->with('success', 'Selamat datang, ' . ($user['nama'] ?? $user['username']));
    }

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin/login')->with('success', 'Anda telah logout');
    }
}