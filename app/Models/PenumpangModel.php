<?php

namespace App\Models;

use CodeIgniter\Model;

class PenumpangModel extends Model
{
    protected $table            = 'PENUMPANG';
    protected $primaryKey       = 'ID_PENUMPANG';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'NAMA_PENUMPANG',
        'NO_IDENTITAS',
        'JENIS_KELAMIN',
        'TANGGAL_LAHIR',
        'NO_TELP'
    ];

    // Dates
    protected $useTimestamps = false;

    // Validation
    protected $validationRules      = [
        'NAMA_PENUMPANG' => 'required|min_length[3]|max_length[100]',
        'NO_IDENTITAS'   => 'required|max_length[100]',
        'JENIS_KELAMIN'  => 'required',
        'TANGGAL_LAHIR'  => 'required|valid_date',
        'NO_TELP'        => 'required|max_length[20]'
    ];
}
