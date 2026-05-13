<?php

namespace App\Models;

use CodeIgniter\Model;

class MaskapaiModel extends Model
{
    protected $table            = 'MASKAPAI';
    protected $primaryKey       = 'ID_MASKAPAI';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['NAMA_MASKAPAI', 'KODE_MASKAPAI', 'NEGARA_ASAL', 'NO_KONTAK'];

    protected $validationRules = [
        'NAMA_MASKAPAI' => 'required|max_length[100]',
        'KODE_MASKAPAI' => 'required|max_length[50]',
        'NEGARA_ASAL'   => 'required|max_length[50]',
    ];
}
