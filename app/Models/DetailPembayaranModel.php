<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailPembayaranModel extends Model
{
    protected $table            = 'DETAIL_PEMBAYARAN';
    protected $primaryKey       = 'ID_MEMBAYAR';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_PEMBAYARAN', 'ID_TIKET', 'TGL_BAYAR', 'JUMLAH_BAYAR', 'STATUS_PEMBAYARAN'];

    protected $validationRules = [
        'ID_PEMBAYARAN'     => 'required|numeric',
        'ID_TIKET'          => 'required|numeric',
        'JUMLAH_BAYAR'      => 'required|decimal',
        'STATUS_PEMBAYARAN' => 'required|max_length[20]',
    ];

    public function getWithRelations()
    {
        return $this->select('DETAIL_PEMBAYARAN.*, PEMBAYARAN.TOTAL_HARGA, METODE_PEMBAYARAN.TIPE_PEMBAYARAN, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG')
                    ->join('PEMBAYARAN', 'PEMBAYARAN.ID_PEMBAYARAN = DETAIL_PEMBAYARAN.ID_PEMBAYARAN', 'left')
                    ->join('METODE_PEMBAYARAN', 'METODE_PEMBAYARAN.ID_METODE = PEMBAYARAN.ID_METODE', 'left')
                    ->join('TIKET', 'TIKET.ID_TIKET = DETAIL_PEMBAYARAN.ID_TIKET', 'left')
                    ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                    ->findAll();
    }
}
