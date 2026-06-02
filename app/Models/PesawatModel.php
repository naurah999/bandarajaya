<?php

namespace App\Models;

use CodeIgniter\Model;

class PesawatModel extends Model
{
    protected $table            = 'PESAWAT';
    protected $primaryKey       = 'ID_PESAWAT';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_MASKAPAI', 'ID_CATALOG', 'KODE_PESAWAT', 'TIPE_PESAWAT', 'KAPASITAS', 'TAHUN_PRODUKSI', 'STATUS_PESAWAT'];

    protected $validationRules = [
        'KODE_PESAWAT'  => 'required|max_length[50]',
        'TIPE_PESAWAT'  => 'permit_empty|max_length[50]',
        'STATUS_PESAWAT'=> 'permit_empty|max_length[50]',
    ];

    public function getWithMaskapai()
    {
        return $this->select('PESAWAT.*, MASKAPAI.NAMA_MASKAPAI, MASKAPAI.KODE_MASKAPAI')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->findAll();
    }

    public function getWithCatalog()
    {
        return $this->select('PESAWAT.*, MASKAPAI.NAMA_MASKAPAI, MASKAPAI.KODE_MASKAPAI, CATALOG_PESAWAT.TIPE_PESAWAT AS CATALOG_TIPE, CATALOG_PESAWAT.KODE_TIPE, CATALOG_PESAWAT.KATEGORI, CATALOG_PESAWAT.TOTAL_KAPASITAS')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->join('CATALOG_PESAWAT', 'CATALOG_PESAWAT.ID_CATALOG = PESAWAT.ID_CATALOG', 'left')
                    ->findAll();
    }
}
