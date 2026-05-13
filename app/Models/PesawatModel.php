<?php

namespace App\Models;

use CodeIgniter\Model;

class PesawatModel extends Model
{
    protected $table            = 'PESAWAT';
    protected $primaryKey       = 'ID_PESAWAT';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_MASKAPAI', 'KODE_PESAWAT', 'TIPE_PESAWAT', 'KAPASITAS', 'TAHUN_PRODUKSI', 'STATUS_PESAWAT'];

    protected $validationRules = [
        'ID_MASKAPAI'   => 'required|numeric',
        'KODE_PESAWAT'  => 'required|max_length[50]',
        'TIPE_PESAWAT'  => 'required|max_length[50]',
        'KAPASITAS'     => 'required|numeric',
        'STATUS_PESAWAT'=> 'permit_empty|max_length[50]',
    ];

    public function getWithMaskapai()
    {
        return $this->select('PESAWAT.*, MASKAPAI.NAMA_MASKAPAI, MASKAPAI.KODE_MASKAPAI')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->findAll();
    }
}
