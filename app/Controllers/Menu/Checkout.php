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

        $this->db->table('transaksi')
            ->where('id', $id)
            ->update([
                'status' => 'menunggu_konfirmasi'
            ]);

        return redirect()->to('/menu/sukses/' . $id);
    }

    public function sukses($id)
    {
        $transaksi = $this->db->table('transaksi')
            ->where('id', $id)
            ->get()
            ->getRowArray();

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