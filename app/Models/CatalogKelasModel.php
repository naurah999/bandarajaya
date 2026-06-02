<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogKelasModel extends Model
{
    protected $table            = 'CATALOG_KELAS';
    protected $primaryKey       = 'ID_CATALOG_KELAS';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_CATALOG', 'NAMA_KELAS', 'LAYOUT_KURSI', 'BARIS_MULAI', 'BARIS_AKHIR', 'HURUF_KURSI', 'WARNA_KELAS'];

    protected $validationRules = [
        'ID_CATALOG'   => 'required|numeric',
        'NAMA_KELAS'   => 'required|max_length[30]',
        'LAYOUT_KURSI' => 'required|max_length[10]',
        'BARIS_MULAI'  => 'required|numeric',
        'BARIS_AKHIR'  => 'required|numeric',
        'HURUF_KURSI'  => 'required|max_length[20]',
        'WARNA_KELAS'  => 'permit_empty|max_length[20]',
    ];
}
