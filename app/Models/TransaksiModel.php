<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'meja',
        'total',
        'metode_pembayaran',
        'created_at'
    ];

    protected $useTimestamps = false;
}
