<?php

namespace App\Controllers\Menu;

use App\Controllers\BaseController;

class Checkout extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function struk()
    {
        $meja   = $this->request->getPost('meja');
        $metode = strtolower($this->request->getPost('metode_bayar'));
        $tipe   = strtolower($this->request->getPost('tipe_pembayaran'));

        if (!$metode || !$tipe) {
            return redirect()->to('/menu/keranjang?meja=' . $meja);
        }

        $keranjang = $this->db->table('keranjang')
            ->where('meja', $meja)
            ->get()
            ->getResultArray();

        if (!$keranjang) {
            return redirect()->to('/menu/keranjang?meja=' . $meja);
        }

        // ==================== VALIDASI STOK SEBELUM CHECKOUT ====================
        foreach ($keranjang as $k) {
            $menu = $this->db->table('menu')
                ->where('id', $k['id_menu'])
                ->get()
                ->getRowArray();
            
            if (!$menu) {
                return redirect()->to('/menu/keranjang?meja=' . $meja)
                    ->with('error', 'Menu tidak ditemukan');
            }
            
            // Cek qty melebihi stok
            if ($k['qty'] > $menu['stok']) {
                return redirect()->to('/menu/keranjang?meja=' . $meja)
                    ->with('error', 'Stok ' . $menu['nama_menu'] . ' tidak cukup. Sisa: ' . $menu['stok']);
            }
            
            // Cek qty melebihi batas maksimal 30
            if ($k['qty'] > 30) {
                return redirect()->to('/menu/keranjang?meja=' . $meja)
                    ->with('error', 'Maksimal pemesanan ' . $menu['nama_menu'] . ' adalah 30');
            }
        }

        $total = 0;
        foreach ($keranjang as $k) {
            $total += $k['harga'] * $k['qty'];
        }

        $this->db->table('transaksi')->insert([
            'meja'               => $meja,
            'total'              => $total,
            'tipe_pembayaran'    => $tipe,
            'metode_pembayaran'  => $metode,
            'status'             => 'pending'
        ]);

        $id_transaksi = $this->db->insertID();

        foreach ($keranjang as $k) {
            $level = $this->request->getPost('level_' . $k['id']);

            $this->db->table('detail_transaksi')->insert([
                'id_transaksi' => $id_transaksi,
                'id_menu'      => $k['id_menu'],
                'nama_menu'    => $k['nama_menu'],
                'harga'        => $k['harga'],
                'qty'          => $k['qty'],
                'subtotal'     => $k['harga'] * $k['qty'],
                'level_pedas'  => $level
            ]);
        }

        $detail = $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id_transaksi)
            ->get()
            ->getResultArray();

        $this->db->table('keranjang')
            ->where('meja', $meja)
            ->delete();

        return view('menu/struk', [
            'detail'       => $detail,
            'total'        => $total,
            'meja'         => $meja,
            'id_transaksi' => $id_transaksi,
            'metode'       => $metode,
            'tipe'         => $tipe
        ]);
    }

    public function bayar()
    {
        $id = $this->request->getPost('id_transaksi');

        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return redirect()->to('/menu/keranjang')->with('error', 'Transaksi tidak ditemukan');
        }

        if ($transaksi['status'] == 'lunas') {
            return redirect()->to('/menu/keranjang')->with('error', 'Transaksi sudah lunas');
        }

        $this->db->table('transaksi')
            ->where('id', $id)
            ->update(['status' => 'menunggu_konfirmasi']);

        return redirect()->to('/menu/sukses/' . $id);
    }

    public function sukses($id)
    {
        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

        if (!$transaksi) {
            return redirect()->to('/menu/keranjang')->with('error', 'Transaksi tidak ditemukan');
        }

        $detail = $this->db->table('detail_transaksi')
            ->where('id_transaksi', $id)
            ->get()
            ->getResultArray();

        return view('menu/sukses', [
            'transaksi' => $transaksi,
            'detail'    => $detail
        ]);
    }
}