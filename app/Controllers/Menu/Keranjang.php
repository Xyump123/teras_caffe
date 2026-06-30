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

    // ============================================================
    // TAMBAH KE KERANJANG
    // ============================================================
    public function tambah()
    {
        $keranjangModel = new KeranjangModel();
        $menuModel      = new MenuModel();

        $id_menu = $this->request->getPost('id_menu');
        $meja    = $this->request->getPost('meja');
        $level_pedas = $this->request->getPost('level_pedas') ?? 0;

        $menu = $menuModel->find($id_menu);

        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan');
        }

        if ($menu['stok'] <= 0) {
            return redirect()->to('/menu?meja=' . $meja)
                ->with('error', 'Stok ' . $menu['nama_menu'] . ' habis!');
        }

        $cek = $keranjangModel
            ->where('id_menu', $id_menu)
            ->where('meja', $meja)
            ->first();

        if ($cek) {
            $qtyBaru = $cek['qty'] + 1;
            
            if ($qtyBaru > $menu['stok']) {
                return redirect()->to('/menu?meja=' . $meja)
                    ->with('error', 'Stok ' . $menu['nama_menu'] . ' tidak cukup. Sisa: ' . $menu['stok']);
            }
            
            if ($qtyBaru > 30) {
                return redirect()->to('/menu?meja=' . $meja)
                    ->with('error', 'Maksimal pemesanan ' . $menu['nama_menu'] . ' adalah 30');
            }

            $keranjangModel->update($cek['id'], [
                'qty' => $qtyBaru,
                'level_pedas' => (int)$level_pedas
            ]);
        } else {
            $keranjangModel->insert([
                'id_menu'   => $menu['id'],
                'nama_menu' => $menu['nama_menu'],
                'harga'     => $menu['harga'],
                'qty'       => 1,
                'meja'      => $meja,
                'level_pedas' => (int)$level_pedas
            ]);
        }

        return redirect()->to('/menu?meja=' . $meja)->with('success', $menu['nama_menu'] . ' ditambahkan');
    }

    // ============================================================
    // LIHAT KERANJANG
    // ============================================================
    public function lihat()
    {
        $meja = $this->request->getGet('meja');

        $keranjang = $this->db->table('keranjang')
            ->select('keranjang.*, menu.kategori, menu.ada_level, menu.stok')
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

    // ============================================================
    // TAMBAH QTY
    // ============================================================
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
            $qtyBaru = $item['qty'] + 1;
            
            if ($qtyBaru > $menu['stok']) {
                return redirect()->to('/menu/keranjang?meja=' . $meja)
                    ->with('error', 'Stok ' . $menu['nama_menu'] . ' tidak cukup. Sisa: ' . $menu['stok']);
            }
            
            if ($qtyBaru > 30) {
                return redirect()->to('/menu/keranjang?meja=' . $meja)
                    ->with('error', 'Maksimal pemesanan ' . $menu['nama_menu'] . ' adalah 30');
            }

            $keranjangModel->update($id, [
                'qty' => $qtyBaru,
                'level_pedas' => $item['level_pedas'] ?? 0
            ]);
        }

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }

    // ============================================================
    // KURANG QTY
    // ============================================================
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
                    'qty' => $item['qty'] - 1,
                    'level_pedas' => $item['level_pedas'] ?? 0
                ]);
            } else {
                $keranjangModel->delete($id);
            }
        }

        return redirect()->to('/menu/keranjang?meja=' . $meja);
    }

    // ============================================================
    // UPDATE LEVEL PEDAS DARI KERANJANG (AJAX) - TERIMA JSON + CSRF
    // ============================================================
    public function updateLevelAjax()
    {
        // Ambil data dari JSON body
        $json = $this->request->getJSON();
        
        $id = $json->id ?? null;
        $level = $json->level ?? 0;

        // Log untuk debug
        log_message('debug', 'UPDATE LEVEL AJAX - ID: ' . $id . ', Level: ' . $level);

        // Validasi ID
        if (empty($id)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID tidak ditemukan'
            ]);
        }

        // Validasi level (0-5)
        $level = (int)$level;
        if ($level < 0 || $level > 5) {
            $level = 0;
        }

        $keranjangModel = new KeranjangModel();
        
        // Cek apakah data ada
        $cek = $keranjangModel->find($id);
        if (!$cek) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Data keranjang tidak ditemukan'
            ]);
        }

        // Update level pedas
        $result = $keranjangModel->update($id, [
            'level_pedas' => $level
        ]);

        log_message('debug', 'UPDATE LEVEL RESULT - ID: ' . $id . ', Result: ' . ($result ? 'SUCCESS' : 'FAILED'));

        if ($result) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Level pedas berhasil diupdate'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Gagal update level pedas'
            ]);
        }
    }

    // ============================================================
    // HAPUS ITEM
    // ============================================================
    public function hapusItem($id, $meja)
    {
        $keranjangModel = new KeranjangModel();
        $keranjangModel->where('id', $id)->where('meja', $meja)->delete();

        return redirect()->to('/menu/keranjang?meja=' . $meja)->with('success', 'Item berhasil dihapus');
    }
}