<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Admin extends BaseController
{
    protected $db;
    protected $session;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->session = session();
    }

    /*
    ======================================
    CEK LOGIN
    ======================================
    */

    private function checkLogin()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/admin/login')->send();
        }
    }

    /*
    ======================================
    LOGIN
    ======================================
    */

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

        // ✅ FIX DISINI
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

    public function registerProcess()
    {
        // VALIDASI
        if (!$this->validate([
            'username' => 'required|min_length[4]|is_unique[users.username]',
            'password' => 'required|min_length[6]'
        ])) {
            return redirect()->back()->withInput()->with('error', 'Username sudah ada / password minimal 6 karakter');
        }

        $model = new \App\Models\UserModel();

        $model->insert([
            'username' => $this->request->getPost('username'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'admin'
        ]);

        return redirect()->to('/admin/login')->with('success', 'Registrasi berhasil!');
    }


    public function profile()
    {
        $this->checkLogin();
        return view('admin/profile');
    }

    public function editProfile()
    {
        $this->checkLogin();
        return view('admin/edit_profile');
    }

    public function updateProfile()
    {
        $this->checkLogin();

        $data = [
            'nama'  => $this->request->getPost('nama'),
            'email' => $this->request->getPost('email'),
            'bio'   => $this->request->getPost('bio'),
        ];

        // upload foto
        $file = $this->request->getFile('foto');

        if ($file && $file->isValid()) {
            $namaFile = $file->getRandomName();
            $file->move('uploads', $namaFile);
            $data['foto'] = $namaFile;
        }

        // update ke database
        $this->db->table('users')
            ->where('id', session('user_id'))
            ->update($data);

        // update session juga
        $this->session->set($data);

        return redirect()->back()->with('success', 'Profile berhasil diupdate');
    }

    /*
    ======================================
    DASHBOARD
    ======================================
    */

    public function dashboard()
    {
        $this->checkLogin();

        $data['transaksi'] = $this->db->table('transaksi')
            ->orderBy('created_at', 'DESC')
            ->limit(10)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', $data);
    }

    /*
    ======================================
    TRANSAKSI
    ======================================
    */

    public function transaksi()
    {
        $this->checkLogin();

        $data['title'] = 'Data Transaksi';

        $data['transaksi'] = $this->db->table('transaksi')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/transaksi', $data);
    }

    public function detail($id)
    {
        $this->checkLogin();

        $data['title'] = 'Detail Transaksi';

        $data['transaksi'] = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        $data['detail'] = $this->db->table('detail_transaksi')
            ->select('detail_transaksi.*, menu.nama_menu')
            ->join('menu', 'menu.id = detail_transaksi.id_menu')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('admin/detail_transaksi', $data);
    }

    /*
    ======================================
    KONFIRMASI PEMBAYARAN
    ======================================
    */

    public function konfirmasi($id)
    {
        $this->checkLogin();

        $detail = $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        foreach ($detail as $d) {

            $menu = $this->db->table('menu')
                ->where('id', $d['id_menu'])
                ->get()
                ->getRowArray();

            if ($menu) {

                $stokBaru = $menu['stok'] - $d['qty'];

                if ($stokBaru < 0) {
                    $stokBaru = 0;
                }

                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        $this->db->table('transaksi')
            ->where('id', $id)
            ->update(['status' => 'lunas']);

        return redirect()->back()->with(
            'success',
            'Transaksi berhasil dikonfirmasi dan stok diperbarui.'
        );
    }

    /*
    ======================================
    MANAJEMEN MENU
    ======================================
    */

    public function menu()
    {
        $this->checkLogin();

        $data['title'] = 'Manage Menu';

        $data['menu'] = $this->db->table('menu')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/menu', $data);
    }

    public function tambahMenu()
    {
        $this->checkLogin();

        $data['title'] = 'Tambah Menu';
        return view('admin/tambah_menu', $data);
    }

    public function simpanMenu()
    {
        $this->checkLogin();

        $file = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($file && $file->isValid()) {
            $namaGambar = $file->getRandomName();
            $file->move('uploads', $namaGambar);
        }

        $this->db->table('menu')->insert([
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => $this->request->getPost('harga'),
            'stok'      => $this->request->getPost('stok'),
            'kategori'  => $this->request->getPost('kategori'),
            'gambar'    => $namaGambar
        ]);

        return redirect()->to('/admin/menu');
    }

    public function editMenu($id)
    {
        $this->checkLogin();

        $data['title'] = 'Edit Menu';

        $data['menu'] = $this->db->table('menu')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        return view('admin/edit_menu', $data);
    }

    public function updateMenu($id)
    {
        $this->checkLogin();

        $file = $this->request->getFile('gambar');

        $dataUpdate = [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => $this->request->getPost('harga'),
            'stok'      => $this->request->getPost('stok'),
            'kategori'  => $this->request->getPost('kategori'),
        ];

        if ($file && $file->isValid()) {
            $namaGambar = $file->getRandomName();
            $file->move('uploads', $namaGambar);
            $dataUpdate['gambar'] = $namaGambar;
        }

        $this->db->table('menu')
            ->where('id', $id)
            ->update($dataUpdate);

        return redirect()->to('/admin/menu');
    }

    public function hapusMenu($id)
    {
        $this->checkLogin();

        $this->db->table('menu')
            ->where('id', $id)
            ->delete();

        return redirect()->to('/admin/menu');
    }

    /*
    ======================================
    LAPORAN
    ======================================
    */

    public function laporan()
    {
        $this->checkLogin();

        $db = \Config\Database::connect();

        $tanggal = $this->request->getPost('tanggal');
        $bulan   = $this->request->getPost('bulan');
        $tahun   = $this->request->getPost('tahun');

        if ($tanggal) {

            $transaksi = $db->table('transaksi')
                ->where('DATE(created_at)', $tanggal)
                ->get()
                ->getResultArray();
        } elseif ($bulan) {

            $bulanAngka = date('m', strtotime($bulan));
            $tahunAngka = date('Y', strtotime($bulan));

            $transaksi = $db->table('transaksi')
                ->where('MONTH(created_at)', $bulanAngka)
                ->where('YEAR(created_at)', $tahunAngka)
                ->get()
                ->getResultArray();
        } elseif ($tahun) {

            $transaksi = $db->table('transaksi')
                ->where('YEAR(created_at)', $tahun)
                ->get()
                ->getResultArray();
        } else {

            $transaksi = $db->table('transaksi')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        // =========================
        // TAMBAHAN UNTUK CHART
        // =========================
        $label = [];
        $total = [];

        foreach ($transaksi as $t) {
            $label[] = date('d-m', strtotime($t['created_at'])); // label tanggal
            $total[] = $t['total']; // nilai pendapatan
        }

        $data = [
            'transaksi' => $transaksi,
            'label'     => $label,
            'total'     => $total
        ];

        return view('admin/laporan', $data);
    }

    /*
    ======================================
    LOGOUT
    ======================================
    */

    public function logout()
    {
        $this->session->destroy();
        return redirect()->to('/admin/login');
    }
}
