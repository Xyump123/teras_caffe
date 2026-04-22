<?php

namespace App\Models;

use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_menu', 'nama_menu', 'harga', 'qty', 'meja'];
}