<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogKelasModel extends Model
{
    protected $table            = 'CATALOG_KELAS';
    protected $primaryKey       = 'ID_CATALOG_KELAS';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_CATALOG', 'NAMA_KELAS', 'WARNA_KELAS', 'HARGA_KELAS'];

    protected $validationRules = [
        'ID_CATALOG'  => 'required|numeric',
        'NAMA_KELAS'  => 'required|max_length[30]',
        'HARGA_KELAS' => 'numeric'
    ];
}
