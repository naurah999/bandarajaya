<?php

namespace App\Models;

use CodeIgniter\Model;

class CheckinModel extends Model
{
    protected $table            = 'CHECKIN';
    protected $primaryKey       = 'ID_CHECKIN';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_TIKET', 'ID_KURSI', 'WAKTU_CHECKIN'];

    protected $validationRules = [
        'ID_TIKET'  => 'required|numeric',
        'ID_KURSI'  => 'required|numeric',
    ];

    public function getWithRelations()
    {
        return $this->select('CHECKIN.*, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG, KURSI.NO_KURSI2, KURSI.KELAS_PENERBANAN, PENERBANGAN.KOTA_ASAL, PENERBANGAN.KOTA_TUJUAN, PENERBANGAN.ID_GATE, GATE.NOMOR_GATE')
                    ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET', 'left')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->join('KURSI', 'KURSI.ID_KURSI = CHECKIN.ID_KURSI', 'left')
                    ->join('PENERBANGAN', 'PENERBANGAN.ID_PENERBANGAN = TIKET.ID_PENERBANGAN', 'left')
                    ->join('GATE', 'GATE.ID_GATE = PENERBANGAN.ID_GATE', 'left')
                    ->findAll();
    }
}
