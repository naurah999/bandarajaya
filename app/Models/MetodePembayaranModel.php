<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodePembayaranModel extends Model
{
    protected $table            = 'METODE_PEMBAYARAN';
    protected $primaryKey       = 'ID_METODE';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['TIPE_PEMBAYARAN'];

    protected $validationRules = [
        'TIPE_PEMBAYARAN' => 'required|max_length[50]',
    ];
}
