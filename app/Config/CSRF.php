<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class CSRF extends BaseConfig
{
    public $tokenName = 'csrf_test_name';
    public $headerName = 'X-CSRF-TOKEN';
    public $cookieName = 'csrf_cookie_name';
    public $expires = 7200;
    public $regenerate = true;
    public $redirect = false;
    
    public $excludeURIs = [
        'admin/transaksi/konfirmasi-ajax/*',
        'admin/transaksi/cek-pesanan-baru',
        'admin/transaksi/get-transaksi-data',
        'menu/keranjang/update-level-ajax',
        'menu/struk',
        'api/*'
    ];
}