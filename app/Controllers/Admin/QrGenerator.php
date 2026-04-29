<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class QrGenerator extends BaseController
{
    private $session;

    public function __construct()
    {
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
        $data['title'] = 'Generate QR Code Meja';
        $data['meja'] = range(1, 20);
        return view('admin/qr_generator', $data);
    }

    public function generate()
    {
        $this->checkLogin();
        
        $meja = $this->request->getPost('meja');
        $size = $this->request->getPost('size') ?? 200;
        
        if (!$meja) {
            return redirect()->back()->with('error', 'Pilih nomor meja');
        }
        
        $url = base_url('menu?meja=' . $meja);
        
        // API QR Code Generator (GRATIS)
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($url);
        
        $folder = FCPATH . 'uploads/qrcode/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        
        $filename = 'meja_' . $meja . '.png';
        $filepath = $folder . $filename;
        
        $qrImage = file_get_contents($qrUrl);
        file_put_contents($filepath, $qrImage);
        
        return redirect()->to('/admin/qr-generator')->with('success', 'QR Code meja ' . $meja . ' berhasil dibuat');
    }

    public function download($meja)
    {
        $this->checkLogin();
        $filepath = FCPATH . 'uploads/qrcode/meja_' . $meja . '.png';
        
        if (file_exists($filepath)) {
            return $this->response->download($filepath, null);
        } else {
            return redirect()->to('/admin/qr-generator')->with('error', 'File tidak ditemukan');
        }
    }

    public function bulkGenerate()
    {
        $this->checkLogin();
        
        $mejas = range(1, 20);
        $size = $this->request->getPost('size') ?? 200;
        $success = 0;
        
        $folder = FCPATH . 'uploads/qrcode/';
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        
        foreach ($mejas as $meja) {
            $url = base_url('menu?meja=' . $meja);
            $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($url);
            
            $filename = 'meja_' . $meja . '.png';
            $filepath = $folder . $filename;
            
            $qrImage = file_get_contents($qrUrl);
            file_put_contents($filepath, $qrImage);
            $success++;
        }
        
        return redirect()->to('/admin/qr-generator')->with('success', 'QR Code berhasil dibuat untuk ' . $success . ' meja');
    }
}