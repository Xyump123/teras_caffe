<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Laporan extends BaseController
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

        $tanggal = $this->request->getPost('tanggal');
        $bulan   = $this->request->getPost('bulan');
        $tahun   = $this->request->getPost('tahun');

        if ($tanggal) {
            $transaksi = $this->db->table('transaksi')
                ->where('DATE(created_at)', $tanggal)
                ->get()
                ->getResultArray();
        } elseif ($bulan) {
            $bulanAngka = date('m', strtotime($bulan));
            $tahunAngka = date('Y', strtotime($bulan));

            $transaksi = $this->db->table('transaksi')
                ->where('MONTH(created_at)', $bulanAngka)
                ->where('YEAR(created_at)', $tahunAngka)
                ->get()
                ->getResultArray();
        } elseif ($tahun) {
            $transaksi = $this->db->table('transaksi')
                ->where('YEAR(created_at)', $tahun)
                ->get()
                ->getResultArray();
        } else {
            $transaksi = $this->db->table('transaksi')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        $label = [];
        $total = [];

        foreach ($transaksi as $t) {
            $label[] = date('d-m', strtotime($t['created_at']));
            $total[] = $t['total'];
        }

        $data = [
            'transaksi' => $transaksi,
            'label'     => $label,
            'total'     => $total
        ];

        return view('admin/laporan', $data);
    }
}