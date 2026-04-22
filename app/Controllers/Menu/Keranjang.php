<?php

namespace App\Controllers\Menu;

use App\Controllers\BaseController;
use App\Models\KeranjangModel;
use App\Models\MenuModel;

class Keranjang extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

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

    public function lihat()
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

    public function hapusItem($id, $meja)
    {
        $keranjangModel = new KeranjangModel();

        $keranjangModel
            ->where('id', $id)
            ->where('meja', $meja)
            ->delete();

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }
}