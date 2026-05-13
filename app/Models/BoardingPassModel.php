<?php

namespace App\Models;

use CodeIgniter\Model;

class BoardingPassModel extends Model
{
    protected $table            = 'BOARDINGPASS';
    protected $primaryKey       = 'ID_BOARDING';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_CHECKIN', 'ID_GATE', 'WAKTU_BOARDING'];

    protected $validationRules = [
        'ID_CHECKIN'     => 'required|numeric',
        'ID_GATE'        => 'required|numeric',
        'WAKTU_BOARDING' => 'required',
    ];

    public function getWithRelations()
    {
        return $this->select('BOARDINGPASS.*, CHECKIN.WAKTU_CHECKIN, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG, GATE.NOMOR_GATE, GATE.TERMINAL, PENERBANGAN.KOTA_ASAL, PENERBANGAN.KOTA_TUJUAN, KURSI.NO_KURSI2, KURSI.KELAS_PENERBANAN')
                    ->join('CHECKIN', 'CHECKIN.ID_CHECKIN = BOARDINGPASS.ID_CHECKIN', 'left')
                    ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET', 'left')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->join('GATE', 'GATE.ID_GATE = BOARDINGPASS.ID_GATE', 'left')
                    ->join('PENERBANGAN', 'PENERBANGAN.ID_PENERBANGAN = TIKET.ID_PENERBANGAN', 'left')
                    ->join('KURSI', 'KURSI.ID_KURSI = CHECKIN.ID_KURSI', 'left')
                    ->findAll();
    }
}
