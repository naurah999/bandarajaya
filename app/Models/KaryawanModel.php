<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $table            = 'karyawan';
    protected $primaryKey       = 'ID_KARYAWAN';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['NAMA_KARYAWAN', 'JABATAN', 'NO_TELP', 'STATUS_KERJA'];

    protected $validationRules = [
        'NAMA_KARYAWAN' => 'required|max_length[100]',
        'JABATAN'       => 'required|max_length[50]',
        'NO_TELP'       => 'permit_empty|max_length[20]',
    ];
}
