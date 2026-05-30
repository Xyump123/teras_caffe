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

    // ==================== MENAMPILKAN DAFTAR TRANSAKSI ====================
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

    // ==================== DETAIL TRANSAKSI ====================
    public function detail($id)
    {
        $this->checkLogin();

        $data['title'] = 'Detail Transaksi';
        $data['transaksi'] = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$data['transaksi']) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        $data['detail'] = $this->db->table('detail_transaksi')
            ->select('detail_transaksi.*, menu.nama_menu')
            ->join('menu', 'menu.id = detail_transaksi.id_menu')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('admin/detail_transaksi', $data);
    }

    // ==================== KONFIRMASI PEMBAYARAN (TANPA AJAX) ====================
    public function konfirmasi($id)
    {
        $this->checkLogin();

        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        if ($transaksi['status'] == 'lunas') {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi sudah lunas');
        }

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
                if ($stokBaru < 0) $stokBaru = 0;
                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        $this->db->table('transaksi')
            ->where('id', $id)
            ->update(['status' => 'lunas']);

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi berhasil dikonfirmasi');
    }

    // ==================== CEK PESANAN BARU (AJAX) ====================
    public function cekPesananBaru()
    {
        $this->checkLogin();

        $lastCheck = $this->session->get('last_notification_check') ?? date('Y-m-d H:i:s', strtotime('-5 minutes'));
        
        $pesananBaru = $this->db->table('transaksi')
            ->select('transaksi.*, (SELECT COUNT(*) FROM detail_transaksi WHERE detail_transaksi.id_transaksi = transaksi.id) as total_item')
            ->where('transaksi.created_at >', $lastCheck)
            ->whereIn('transaksi.status', ['pending', 'menunggu_konfirmasi'])
            ->orderBy('transaksi.created_at', 'DESC')
            ->get()
            ->getResultArray();

        $this->session->set('last_notification_check', date('Y-m-d H:i:s'));

        return $this->response->setJSON([
            'success' => true,
            'total_baru' => count($pesananBaru),
            'pesanan' => $pesananBaru
        ]);
    }

    // ==================== KONFIRMASI PEMBAYARAN VIA AJAX ====================
    public function konfirmasiAjax($id)
    {
        $this->checkLogin();

        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Transaksi tidak ditemukan'
            ]);
        }

        if ($transaksi['status'] == 'lunas') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Transaksi sudah lunas'
            ]);
        }

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
                if ($stokBaru < 0) $stokBaru = 0;
                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        $this->db->table('transaksi')
            ->where('id', $id)
            ->update(['status' => 'lunas']);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Transaksi berhasil dikonfirmasi'
        ]);
    }

    // ==================== AMBIL DATA TRANSAKSI (AJAX) ====================
    public function getTransaksiData()
    {
        $this->checkLogin();

        $transaksi = $this->db->table('transaksi')
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResultArray();

        $html = '';
        foreach ($transaksi as $t) {
            $html .= '<tr id="transaksi-' . $t['id'] . '" data-id="' . $t['id'] . '">';
            $html .= '<td class="col-id"><strong>#' . $t['id'] . '</strong></td>';
            $html .= '<td class="col-meja">' . $t['meja'] . '</td>';
            $html .= '<td class="col-tipe"><span class="badge ' . strtolower($t['tipe_pembayaran'] ?? 'meja') . '">' . strtoupper($t['tipe_pembayaran'] ?? 'MEJA') . '</span></td>';
            $html .= '<td class="col-metode"><span class="badge ' . strtolower($t['metode_pembayaran'] ?? 'cash') . '">' . strtoupper($t['metode_pembayaran'] ?? 'CASH') . '</span></td>';
            $html .= '<td class="col-total">Rp ' . number_format($t['total'], 0, ',', '.') . '</td>';
            $html .= '<td class="col-status"><span class="badge ' . strtolower($t['status']) . '">' . strtoupper($t['status']) . '</span></td>';
            $html .= '<td class="col-tanggal">' . date('d-m-Y H:i', strtotime($t['created_at'])) . '</td>';
            $html .= '<td class="col-aksi action">';
            $html .= '<a href="' . base_url('admin/transaksi/detail/' . $t['id']) . '" class="btn-detail">Detail</a> ';
            $html .= '<a href="' . base_url('admin/transaksi/edit/' . $t['id']) . '" class="btn-edit">Edit</a> ';
            if ($t['status'] != 'lunas') {
                $html .= '<button type="button" class="btn-konfirmasi" data-id="' . $t['id'] . '">Konfirmasi</button>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }

        return $this->response->setJSON([
            'success' => true,
            'html' => $html
        ]);
    }

    // ==================== TAMBAH TRANSAKSI ====================
    public function tambah()
    {
        $this->checkLogin();

        $data['title'] = 'Tambah Transaksi';
        $data['menu'] = $this->db->table('menu')
            ->orderBy('kategori', 'ASC')
            ->orderBy('nama_menu', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/tambah_transaksi', $data);
    }

    // ==================== SIMPAN TRANSAKSI ====================
    public function simpan()
    {
        $this->checkLogin();

        $meja = $this->request->getPost('meja');
        $metode = $this->request->getPost('metode_pembayaran');
        $status = $this->request->getPost('status');
        $items = $this->request->getPost('items');

        if (!$items || count($items) == 0) {
            return redirect()->back()->with('error', 'Minimal 1 item');
        }

        $total = 0;
        $detailData = [];

        foreach ($items as $item) {
            if (empty($item['id_menu']) || empty($item['qty'])) {
                continue;
            }

            $menu = $this->db->table('menu')
                ->where('id', $item['id_menu'])
                ->get()
                ->getRowArray();

            if ($menu) {
                $qty = (int)$item['qty'];

                if ($qty > 30) {
                    return redirect()->back()->with('error', 'Maksimal 30 untuk ' . $menu['nama_menu']);
                }

                if ($qty > $menu['stok']) {
                    return redirect()->back()->with('error', 'Stok ' . $menu['nama_menu'] . ' sisa ' . $menu['stok']);
                }

                $subtotal = $menu['harga'] * $qty;
                $total += $subtotal;

                $detailData[] = [
                    'id_menu'    => $menu['id'],
                    'nama_menu'  => $menu['nama_menu'],
                    'harga'      => $menu['harga'],
                    'qty'        => $qty,
                    'subtotal'   => $subtotal,
                    'level_pedas'=> $item['level_pedas'] ?? null
                ];
            }
        }

        if (empty($detailData)) {
            return redirect()->back()->with('error', 'Tidak ada item valid');
        }

        $this->db->table('transaksi')->insert([
            'meja'          => $meja,
            'total'         => $total,
            'metode_pembayaran' => $metode,
            'status'        => $status,
            'tipe_pembayaran' => 'kasir',
            'created_at'    => date('Y-m-d H:i:s')
        ]);

        $id_transaksi = $this->db->insertID();

        foreach ($detailData as $detail) {
            $detail['id_transaksi'] = $id_transaksi;
            $this->db->table('detail_transaksi')->insert($detail);
        }

        if ($status == 'lunas') {
            foreach ($detailData as $detail) {
                $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->set('stok', 'stok - ' . $detail['qty'], false)
                    ->update();
            }
        }

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi ditambahkan');
    }

    // ==================== EDIT TRANSAKSI ====================
    public function edit($id)
    {
        $this->checkLogin();

        $data['title'] = 'Edit Transaksi';
        $data['transaksi'] = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$data['transaksi']) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        $data['detail'] = $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        $data['menu'] = $this->db->table('menu')
            ->orderBy('kategori', 'ASC')
            ->orderBy('nama_menu', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/edit_transaksi', $data);
    }

    // ==================== UPDATE TRANSAKSI ====================
    public function update($id)
    {
        $this->checkLogin();

        $meja = $this->request->getPost('meja');
        $metode = $this->request->getPost('metode_pembayaran');
        $status = $this->request->getPost('status');
        $items = $this->request->getPost('items');

        if (!$items || count($items) == 0) {
            return redirect()->back()->with('error', 'Minimal 1 item');
        }

        $oldTransaksi = $this->db->table('transaksi')->where('id', $id)->get()->getRowArray();
        $oldDetail = $this->db->table('detail_transaksi')->where('id_transaksi', $id)->get()->getResultArray();

        if (!$oldTransaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        if ($oldTransaksi['status'] == 'lunas') {
            foreach ($oldDetail as $d) {
                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->set('stok', 'stok + ' . $d['qty'], false)
                    ->update();
            }
        }

        $this->db->table('detail_transaksi')->where('id_transaksi', $id)->delete();

        $total = 0;
        $detailData = [];

        foreach ($items as $item) {
            if (empty($item['id_menu']) || empty($item['qty'])) {
                continue;
            }

            $menu = $this->db->table('menu')->where('id', $item['id_menu'])->get()->getRowArray();

            if ($menu) {
                $qty = (int)$item['qty'];

                if ($qty > 30) {
                    return redirect()->back()->with('error', 'Maksimal 30 untuk ' . $menu['nama_menu']);
                }

                if ($qty > $menu['stok']) {
                    return redirect()->back()->with('error', 'Stok ' . $menu['nama_menu'] . ' sisa ' . $menu['stok']);
                }

                $subtotal = $menu['harga'] * $qty;
                $total += $subtotal;

                $detailData[] = [
                    'id_transaksi' => $id,
                    'id_menu'      => $menu['id'],
                    'nama_menu'    => $menu['nama_menu'],
                    'harga'        => $menu['harga'],
                    'qty'          => $qty,
                    'subtotal'     => $subtotal,
                    'level_pedas'  => $item['level_pedas'] ?? null
                ];
            }
        }

        if (empty($detailData)) {
            return redirect()->back()->with('error', 'Tidak ada item valid');
        }

        $this->db->table('transaksi')->where('id', $id)->update([
            'meja'   => $meja,
            'total'  => $total,
            'metode_pembayaran' => $metode,
            'status' => $status
        ]);

        foreach ($detailData as $detail) {
            $this->db->table('detail_transaksi')->insert($detail);
        }

        if ($status == 'lunas') {
            foreach ($detailData as $d) {
                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->set('stok', 'stok - ' . $d['qty'], false)
                    ->update();
            }
        }

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi berhasil diupdate');
    }
    public function print($id)
{
    $this->checkLogin();

    $data['transaksi'] = $this->db->table('transaksi')
        ->where('id', $id)
        ->get()
        ->getRowArray();

    if (!$data['transaksi']) {
        return redirect()->to('/admin/transaksi');
    }

    $data['detail'] = $this->db->table('detail_transaksi')
        ->select('detail_transaksi.*, menu.nama_menu')
        ->join('menu', 'menu.id = detail_transaksi.id_menu')
        ->where('id_transaksi', $id)
        ->get()
        ->getResultArray();

    return view('admin/print_transaksi', $data);
}
}