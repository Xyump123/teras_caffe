<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class MenuManager extends BaseController
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

        $data['title'] = 'Manage Menu';
        $data['menu'] = $this->db->table('menu')
            ->orderBy('id', 'DESC')
            ->get()
            ->getResultArray();

        return view('admin/menu', $data);
    }

    public function tambah()
    {
        $this->checkLogin();
        $data['title'] = 'Tambah Menu';
        return view('admin/tambah_menu', $data);
    }

    public function simpan()
    {
        $this->checkLogin();

        $file = $this->request->getFile('gambar');
        $namaGambar = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaGambar = $file->getRandomName();
            
            // UNIVERSAL: Gunakan FCPATH untuk semua hosting
            $uploadPath = FCPATH . 'uploads/';
            
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            
            $file->move($uploadPath, $namaGambar);
        }

        $harga = str_replace('.', '', $this->request->getPost('harga'));

        $this->db->table('menu')->insert([
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => $harga,
            'stok'      => $this->request->getPost('stok'),
            'kategori'  => $this->request->getPost('kategori'),
            'gambar'    => $namaGambar
        ]);

        session()->setFlashdata('success', 'Menu berhasil ditambahkan');
        return redirect()->to('/admin/menu');
    }

    public function edit($id)
    {
        $this->checkLogin();

        $data['title'] = 'Edit Menu';
        $data['menu'] = $this->db->table('menu')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$data['menu']) {
            return redirect()->to('/admin/menu')->with('error', 'Menu tidak ditemukan');
        }

        return view('admin/edit_menu', $data);
    }

    public function update($id)
    {
        $this->checkLogin();

        $file = $this->request->getFile('gambar');
        $harga = str_replace('.', '', $this->request->getPost('harga'));

        $dataUpdate = [
            'nama_menu' => $this->request->getPost('nama_menu'),
            'harga'     => $harga,
            'stok'      => $this->request->getPost('stok'),
            'kategori'  => $this->request->getPost('kategori'),
        ];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $oldMenu = $this->db->table('menu')->where('id', $id)->get()->getRowArray();
            $oldPath = FCPATH . 'uploads/' . $oldMenu['gambar'];
            if ($oldMenu && $oldMenu['gambar'] && file_exists($oldPath)) {
                unlink($oldPath);
            }

            $namaGambar = $file->getRandomName();
            $uploadPath = FCPATH . 'uploads/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
            $file->move($uploadPath, $namaGambar);
            $dataUpdate['gambar'] = $namaGambar;
        }

        $this->db->table('menu')->where('id', $id)->update($dataUpdate);
        session()->setFlashdata('success', 'Menu berhasil diupdate');
        return redirect()->to('/admin/menu');
    }

    public function hapus($id)
    {
        $this->checkLogin();

        $menu = $this->db->table('menu')->where('id', $id)->get()->getRowArray();
        $filePath = FCPATH . 'uploads/' . $menu['gambar'];
        if ($menu && $menu['gambar'] && file_exists($filePath)) {
            unlink($filePath);
        }

        $this->db->table('menu')->where('id', $id)->delete();
        session()->setFlashdata('success', 'Menu berhasil dihapus');
        return redirect()->to('/admin/menu');
    }
}