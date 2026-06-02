<?php

namespace App\Models;

use CodeIgniter\Model;

class TiketModel extends Model
{
    protected $table            = 'TIKET';
    protected $primaryKey       = 'ID_TIKET';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_PENUMPANG', 'ID_MEMBAYAR', 'ID_PENERBANGAN', 'NOMER_TIKET', 'HARGA', 'KELAS_TIKET'];

    protected $validationRules = [
        'ID_PENUMPANG'   => 'required|numeric',
        'ID_PENERBANGAN' => 'required|numeric',
        'NOMER_TIKET'    => 'required|max_length[30]',
        'HARGA'          => 'permit_empty|decimal',
    ];

    public function getWithRelations()
    {
        return $this->select('TIKET.*, PENUMPANG.NAMA_PENUMPANG, PENUMPANG.NO_IDENTITAS, PENERBANGAN.KOTA_ASAL, PENERBANGAN.KOTA_TUJUAN, PENERBANGAN.TANGGAL_BERANGKAT, PENERBANGAN.WAKTU_BERANGKAT, MASKAPAI.NAMA_MASKAPAI')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->join('PENERBANGAN', 'PENERBANGAN.ID_PENERBANGAN = TIKET.ID_PENERBANGAN', 'left')
                    ->join('PESAWAT', 'PESAWAT.ID_PESAWAT = PENERBANGAN.ID_PESAWAT', 'left')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->findAll();
    }

    public function getUnpaidTikets()
    {
        return $this->select('TIKET.*, PENUMPANG.NAMA_PENUMPANG')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->where('TIKET.ID_MEMBAYAR', null)
                    ->findAll();
    }
}
