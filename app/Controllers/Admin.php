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
        $password = $this->request->getPost('password');

        $user = $this->db->table('users')
            ->where('username', $username)
            ->get()
            ->getRowArray();

        if (!$user) {
            return redirect()->back()->with('error', 'Username tidak ditemukan');
        }

        if ($password !== $user['password']) {
            return redirect()->back()->with('error', 'Password salah');
        }

        $this->session->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'username'  => $user['username'],
            'role'      => $user['role']
        ]);

        return redirect()->to('/admin/dashboard');
    }

    /*
    ======================================
    DASHBOARD
    ======================================
    */

    public function dashboard()
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/admin/login');
        }

        $data['transaksi'] = $this->db->table('transaksi')
            ->orderBy('id', 'DESC')
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
        $data['title'] = 'Data Transaksi';

        $data['transaksi'] = $this->db->table('transaksi')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/transaksi', $data);
    }

    public function detail($id)
    {
        $data['title'] = 'Detail Transaksi';

        $data['transaksi'] = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        $data['detail'] = $this->db->table('detail_transaksi')
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
            'Transaksi berhasil dikonfirmasi & stok diperbarui.'
        );
    }

    /*
    ======================================
    MANAJEMEN MENU
    ======================================
    */

    public function menu()
    {
        $data['title'] = 'Manage Menu';

        $data['menu'] = $this->db->table('menu')
            ->get()
            ->getResultArray();

        return view('admin/menu', $data);
    }

    public function tambahMenu()
    {
        $data['title'] = 'Tambah Menu';
        return view('admin/tambah_menu', $data);
    }

    public function simpanMenu()
    {
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
        $data['title'] = 'Edit Menu';

        $data['menu'] = $this->db->table('menu')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        return view('admin/edit_menu', $data);
    }

    public function updateMenu($id)
    {
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
        $db = \Config\Database::connect();

        $tanggal = $this->request->getPost('tanggal');
        $bulan   = $this->request->getPost('bulan');
        $tahun   = $this->request->getPost('tahun');

        if ($tanggal) {

            $transaksi = $db->table('transaksi')
                ->where('DATE(created_at)', $tanggal)
                ->get()
                ->getResultArray();

            $grafik = $db->query("
                SELECT HOUR(created_at) as label, SUM(total) as total
                FROM transaksi
                WHERE DATE(created_at) = '$tanggal'
                GROUP BY HOUR(created_at)
            ")->getResultArray();
        } elseif ($bulan) {

            $bulanAngka = date('m', strtotime($bulan));
            $tahunAngka = date('Y', strtotime($bulan));

            $transaksi = $db->table('transaksi')
                ->where('MONTH(created_at)', $bulanAngka)
                ->where('YEAR(created_at)', $tahunAngka)
                ->get()
                ->getResultArray();

            $grafik = $db->query("
                SELECT DAY(created_at) as label, SUM(total) as total
                FROM transaksi
                WHERE MONTH(created_at) = '$bulanAngka'
                AND YEAR(created_at) = '$tahunAngka'
                GROUP BY DAY(created_at)
            ")->getResultArray();
        } elseif ($tahun) {

            $transaksi = $db->table('transaksi')
                ->where('YEAR(created_at)', $tahun)
                ->get()
                ->getResultArray();

            $grafik = $db->query("
                SELECT MONTH(created_at) as label, SUM(total) as total
                FROM transaksi
                WHERE YEAR(created_at) = '$tahun'
                GROUP BY MONTH(created_at)
            ")->getResultArray();
        } else {

            $transaksi = $db->table('transaksi')
                ->orderBy('id', 'DESC')
                ->get()
                ->getResultArray();

            $grafik = $db->query("
                SELECT DATE(created_at) as label, SUM(total) as total
                FROM transaksi
                GROUP BY DATE(created_at)
                ORDER BY DATE(created_at) DESC
                LIMIT 7
            ")->getResultArray();
        }

        $label = array_column($grafik, 'label');
        $total = array_column($grafik, 'total');

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
