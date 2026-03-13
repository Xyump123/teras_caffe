<?php

namespace App\Controllers;

use App\Models\MenuModel;
use App\Models\KeranjangModel;

class Menu extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    /*
    ======================================
    MENU LIST
    ======================================
    */
    public function index()
    {
        $menuModel = new MenuModel();
        $meja = $this->request->getGet('meja') ?? 0;

        return view('menu/index', [
            'menu' => $menuModel->findAll(),
            'meja' => $meja
        ]);
    }

    /*
    ======================================
    TAMBAH KE KERANJANG
    ======================================
    */
    public function tambah()
    {
        $keranjangModel = new KeranjangModel();
        $menuModel      = new MenuModel();

        $id_menu = $this->request->getPost('id_menu');
        $meja    = $this->request->getPost('meja');

        $menu = $menuModel->find($id_menu);

        if (!$menu) {
            return redirect()->back();
        }

        if ($menu['stok'] <= 0) {
            return redirect()->to('/menu?meja=' . $meja)
                ->with('error', 'Stok habis');
        }

        // CEK ITEM DI KERANJANG
        $cek = $keranjangModel
            ->where('id_menu', $id_menu)
            ->where('meja', $meja)
            ->first();

        if ($cek) {

            if ($cek['qty'] + 1 > $menu['stok']) {
                return redirect()->to('/menu?meja=' . $meja)
                    ->with('error', 'Stok tidak cukup');
            }

            $keranjangModel->update($cek['id'], [
                'qty' => $cek['qty'] + 1
            ]);
        } else {

            $keranjangModel->insert([
                'id_menu'   => $menu['id'],
                'nama_menu' => $menu['nama_menu'],
                'harga'     => $menu['harga'],
                'qty'       => 1,
                'meja'      => $meja
            ]);
        }

        return redirect()->to('/menu?meja=' . $meja);
    }

    /*
    ======================================
    TAMPIL KERANJANG
    ======================================
    */
    public function keranjang()
    {
        $meja = $this->request->getGet('meja');

        $keranjang = $this->db->table('keranjang')
            ->select('keranjang.*, menu.kategori, menu.ada_level')
            ->join('menu', 'menu.id = keranjang.id_menu')
            ->where('keranjang.meja', $meja)
            ->get()
            ->getResultArray();

        $total = 0;

        foreach ($keranjang as $k) {
            $total += $k['harga'] * $k['qty'];
        }

        return view('menu/keranjang', [
            'keranjang' => $keranjang,
            'meja'      => $meja,
            'total'     => $total
        ]);
    }

    /*
    ======================================
    TAMBAH QTY
    ======================================
    */
    public function tambahQty($id, $meja)
    {
        $keranjangModel = new KeranjangModel();
        $menuModel      = new MenuModel();

        $item = $keranjangModel
            ->where('id', $id)
            ->where('meja', $meja)
            ->first();

        if ($item) {

            $menu = $menuModel->find($item['id_menu']);

            if ($item['qty'] < $menu['stok']) {

                $keranjangModel->update($id, [
                    'qty' => $item['qty'] + 1
                ]);
            }
        }

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }

    /*
    ======================================
    KURANG QTY
    ======================================
    */
    public function kurangQty($id, $meja)
    {
        $keranjangModel = new KeranjangModel();

        $item = $keranjangModel
            ->where('id', $id)
            ->where('meja', $meja)
            ->first();

        if ($item) {

            if ($item['qty'] > 1) {

                $keranjangModel->update($id, [
                    'qty' => $item['qty'] - 1
                ]);
            } else {

                $keranjangModel->delete($id);
            }
        }

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }

    /*
    ======================================
    HAPUS ITEM KERANJANG
    ======================================
    */
    public function hapusItem($id, $meja)
    {
        $keranjangModel = new KeranjangModel();

        $keranjangModel
            ->where('id', $id)
            ->where('meja', $meja)
            ->delete();

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }

    /*
    ======================================
    STRUK PEMESANAN
    ======================================
    */
    public function struk()
    {
        $meja   = $this->request->getPost('meja');
        $metode = strtolower($this->request->getPost('metode_bayar'));

        if (!$metode) {
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

        // INSERT TRANSAKSI
        $this->db->table('transaksi')->insert([
            'meja'               => $meja,
            'total'              => $total,
            'metode_pembayaran'  => $metode,
            'status'             => 'pending'
        ]);

        $id_transaksi = $this->db->insertID();

        // INSERT DETAIL TRANSAKSI
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

        // HAPUS KERANJANG
        $this->db->table('keranjang')
            ->where('meja', $meja)
            ->delete();

        return view('menu/struk', [
            'detail'       => $detail,
            'total'        => $total,
            'meja'         => $meja,
            'id_transaksi' => $id_transaksi,
            'metode'       => $metode
        ]);
    }

    /*
    ======================================
    PROSES BAYAR
    ======================================
    */
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

    /*
    ======================================
    HALAMAN SUKSES
    ======================================
    */
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
