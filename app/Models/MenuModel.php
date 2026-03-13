<?php

namespace App\Models;

use CodeIgniter\Model;

class MenuModel extends Model
{
    protected $table = 'menu';

    // PRIMARY KEY SESUAI DATABASE
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama_menu',
        'harga',
        'stok',
        'kategori',
        'gambar',
        'created_at'
    ];
}
