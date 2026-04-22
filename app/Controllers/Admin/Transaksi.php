<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Transaksi extends BaseController
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

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi dan stok diperbarui.');
    }
}