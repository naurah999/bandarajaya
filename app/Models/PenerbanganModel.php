<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerbanganModel extends Model
{
    protected $table            = 'PENERBANGAN';
    protected $primaryKey       = 'ID_PENERBANGAN';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_PESAWAT', 'ID_GATE', 'TANGGAL_BERANGKAT', 'WAKTU_BERANGKAT', 'KOTA_ASAL', 'KOTA_TUJUAN'];

    protected $validationRules = [
        'ID_PESAWAT'        => 'required|numeric',
        'KOTA_ASAL'         => 'required|max_length[100]',
        'KOTA_TUJUAN'       => 'required|max_length[100]',
        'TANGGAL_BERANGKAT' => 'required',
        'WAKTU_BERANGKAT'   => 'required',
    ];

    public function getWithRelations()
    {
        return $this->select('PENERBANGAN.*, PESAWAT.TIPE_PESAWAT, MASKAPAI.NAMA_MASKAPAI, MASKAPAI.KODE_MASKAPAI, GATE.NOMOR_GATE, GATE.TERMINAL')
                    ->join('PESAWAT', 'PESAWAT.ID_PESAWAT = PENERBANGAN.ID_PESAWAT', 'left')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->join('GATE', 'GATE.ID_GATE = PENERBANGAN.ID_GATE', 'left')
                    ->orderBy('TANGGAL_BERANGKAT', 'ASC')
                    ->orderBy('WAKTU_BERANGKAT', 'ASC')
                    ->findAll();
    }
}
