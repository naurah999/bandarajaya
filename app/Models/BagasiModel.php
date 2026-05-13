<?php

namespace App\Models;

use CodeIgniter\Model;

class BagasiModel extends Model
{
    protected $table            = 'BAGASI';
    protected $primaryKey       = 'ID_BAGASI';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_CHECKIN', 'BERAT_BAGASI', 'STATUS_BAGASI'];

    protected $validationRules = [
        'ID_CHECKIN'    => 'required|numeric',
        'BERAT_BAGASI'  => 'required|decimal',
        'STATUS_BAGASI' => 'required|max_length[20]',
    ];

    public function getWithRelations()
    {
        return $this->select('BAGASI.*, CHECKIN.WAKTU_CHECKIN, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG')
                    ->join('CHECKIN', 'CHECKIN.ID_CHECKIN = BAGASI.ID_CHECKIN', 'left')
                    ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET', 'left')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->findAll();
    }
}
