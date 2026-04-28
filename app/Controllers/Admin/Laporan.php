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
        
        // Simpan parameter filter untuk pagination
        $queryParams = [];

        if ($tanggal) {
            $transaksi = $this->db->table('transaksi')
                ->where('DATE(created_at)', $tanggal)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
            $queryParams['tanggal'] = $tanggal;
        } elseif ($bulan) {
            $bulanAngka = date('m', strtotime($bulan));
            $tahunAngka = date('Y', strtotime($bulan));

            $transaksi = $this->db->table('transaksi')
                ->where('MONTH(created_at)', $bulanAngka)
                ->where('YEAR(created_at)', $tahunAngka)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
            $queryParams['bulan'] = $bulan;
        } elseif ($tahun) {
            $transaksi = $this->db->table('transaksi')
                ->where('YEAR(created_at)', $tahun)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
            $queryParams['tahun'] = $tahun;
        } else {
            $transaksi = $this->db->table('transaksi')
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        }

        // Data untuk grafik
        $label = [];
        $chartTotal = [];
        foreach ($transaksi as $t) {
            $label[] = date('d-m', strtotime($t['created_at']));
            $chartTotal[] = $t['total'];
        }

        // Total statistik
        $totalTransaksi = count($transaksi);
        $totalPendapatan = array_sum(array_column($transaksi, 'total'));

        // ==================== PAGINATION ====================
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;
        $halamanAktif = (int)$page;
        $mulai = ($halamanAktif - 1) * $perPage;
        $totalHalaman = ceil($totalTransaksi / $perPage);
        
        // Ambil data per halaman
        $transaksiPerPage = array_slice($transaksi, $mulai, $perPage);

        $data = [
            'transaksi' => $transaksi,
            'transaksiPerPage' => $transaksiPerPage,
            'totalTransaksi' => $totalTransaksi,
            'totalPendapatan' => $totalPendapatan,
            'label' => $label,
            'total' => $chartTotal,
            'tanggal' => $tanggal,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'perPage' => $perPage,
            'halamanAktif' => $halamanAktif,
            'totalHalaman' => $totalHalaman,
            'mulai' => $mulai,
            'queryParams' => $queryParams
        ];

        return view('admin/laporan', $data);
    }
}