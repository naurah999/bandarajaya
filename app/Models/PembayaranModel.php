<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table            = 'PEMBAYARAN';
    protected $primaryKey       = 'ID_PEMBAYARAN';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_METODE', 'JUMLAH_TIKET', 'TOTAL_HARGA'];

    protected $validationRules = [
        'ID_METODE'    => 'required|numeric',
        'JUMLAH_TIKET' => 'required|numeric',
        'TOTAL_HARGA'  => 'required|decimal',
    ];

    public function getWithMetode()
    {
        return $this->select('PEMBAYARAN.*, METODE_PEMBAYARAN.TIPE_PEMBAYARAN')
                    ->join('METODE_PEMBAYARAN', 'METODE_PEMBAYARAN.ID_METODE = PEMBAYARAN.ID_METODE', 'left')
                    ->findAll();
    }
}
