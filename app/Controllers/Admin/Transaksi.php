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

    // ==================== KONFIRMASI PEMBAYARAN ====================
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

    // ==================== TAMBAH TRANSAKSI MANUAL ====================
    public function tambah()
    {
        $this->checkLogin();

        $data['title'] = 'Tambah Transaksi Manual';
        $data['menu'] = $this->db->table('menu')
            ->where('stok >', 0)
            ->orderBy('kategori', 'ASC')
            ->orderBy('nama_menu', 'ASC')
            ->get()
            ->getResultArray();

        return view('admin/tambah_transaksi', $data);
    }

    public function simpan()
    {
        $this->checkLogin();

        $meja = $this->request->getPost('meja');
        $metode = $this->request->getPost('metode_pembayaran');
        $status = $this->request->getPost('status');
        $items = $this->request->getPost('items');

        if (!$items || count($items) == 0) {
            return redirect()->back()->with('error', 'Minimal 1 item pesanan');
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
                $subtotal = $menu['harga'] * $item['qty'];
                $total += $subtotal;

                $detailData[] = [
                    'id_menu' => $menu['id'],
                    'nama_menu' => $menu['nama_menu'],
                    'harga' => $menu['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                    'level_pedas' => $item['level_pedas'] ?? null
                ];
            }
        }

        if (empty($detailData)) {
            return redirect()->back()->with('error', 'Tidak ada item yang valid');
        }

        // Simpan transaksi
        $this->db->table('transaksi')->insert([
            'meja' => $meja,
            'total' => $total,
            'metode_pembayaran' => $metode,
            'status' => $status,
            'tipe_pembayaran' => 'kasir',
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $id_transaksi = $this->db->insertID();

        // Simpan detail transaksi
        foreach ($detailData as $detail) {
            $detail['id_transaksi'] = $id_transaksi;
            $this->db->table('detail_transaksi')->insert($detail);
        }

        // Jika status langsung lunas, kurangi stok
        if ($status == 'lunas') {
            foreach ($detailData as $detail) {
                $menu = $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->get()
                    ->getRowArray();

                $stokBaru = $menu['stok'] - $detail['qty'];
                if ($stokBaru < 0) $stokBaru = 0;

                $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi berhasil ditambahkan');
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

    public function update($id)
    {
        $this->checkLogin();

        $meja = $this->request->getPost('meja');
        $metode = $this->request->getPost('metode_pembayaran');
        $status = $this->request->getPost('status');
        $items = $this->request->getPost('items');

        if (!$items || count($items) == 0) {
            return redirect()->back()->with('error', 'Minimal 1 item pesanan');
        }

        // Ambil transaksi lama
        $oldTransaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$oldTransaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil detail lama untuk mengembalikan stok jika perlu
        $oldDetail = $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        // Kembalikan stok jika status sebelumnya lunas
        if ($oldTransaksi['status'] == 'lunas') {
            foreach ($oldDetail as $detail) {
                $menu = $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->get()
                    ->getRowArray();

                $stokBaru = $menu['stok'] + $detail['qty'];
                $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        // Hapus detail lama
        $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->delete();

        // Hitung total dan simpan detail baru
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
                $subtotal = $menu['harga'] * $item['qty'];
                $total += $subtotal;

                $detailData[] = [
                    'id_transaksi' => $id,
                    'id_menu' => $menu['id'],
                    'nama_menu' => $menu['nama_menu'],
                    'harga' => $menu['harga'],
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                    'level_pedas' => $item['level_pedas'] ?? null
                ];
            }
        }

        if (empty($detailData)) {
            return redirect()->back()->with('error', 'Tidak ada item yang valid');
        }

        // Update transaksi
        $this->db->table('transaksi')
            ->where('id', $id)
            ->update([
                'meja' => $meja,
                'total' => $total,
                'metode_pembayaran' => $metode,
                'status' => $status
            ]);

        // Simpan detail baru
        foreach ($detailData as $detail) {
            $this->db->table('detail_transaksi')->insert($detail);
        }

        // Jika status baru lunas, kurangi stok
        if ($status == 'lunas') {
            foreach ($detailData as $detail) {
                $menu = $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->get()
                    ->getRowArray();

                $stokBaru = $menu['stok'] - $detail['qty'];
                if ($stokBaru < 0) $stokBaru = 0;

                $this->db->table('menu')
                    ->where('id', $detail['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi berhasil diupdate');
    }

    // ==================== HAPUS TRANSAKSI ====================
    public function hapus($id)
    {
        $this->checkLogin();

        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return redirect()->to('/admin/transaksi')->with('error', 'Transaksi tidak ditemukan');
        }

        // Ambil detail untuk mengembalikan stok jika status lunas
        if ($transaksi['status'] == 'lunas') {
            $detail = $this->db->table('detail_transaksi')
                ->where('id_transaksi', $id)
                ->get()
                ->getResultArray();

            foreach ($detail as $d) {
                $menu = $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->get()
                    ->getRowArray();

                $stokBaru = $menu['stok'] + $d['qty'];
                $this->db->table('menu')
                    ->where('id', $d['id_menu'])
                    ->update(['stok' => $stokBaru]);
            }
        }

        // Hapus detail transaksi
        $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->delete();

        // Hapus transaksi
        $this->db->table('transaksi')
            ->where('id', $id)
            ->delete();

        return redirect()->to('/admin/transaksi')->with('success', 'Transaksi berhasil dihapus');
    }
}