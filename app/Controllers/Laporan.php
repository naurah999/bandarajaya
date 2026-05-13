<?php

namespace App\Controllers;

use App\Models\DetailPembayaranModel;
use App\Models\PenerbanganModel;
use App\Models\TiketModel;

class Laporan extends BaseController
{
    public function penjualan()
    {
        $detailModel = new DetailPembayaranModel();
        
        $start = $this->request->getGet('start_date') ?? date('Y-m-01');
        $end = $this->request->getGet('end_date') ?? date('Y-m-d');

        $data = [
            'title'      => 'Laporan Penjualan',
            'start_date' => $start,
            'end_date'   => $end,
            'penjualan'  => $detailModel->select('DETAIL_PEMBAYARAN.*, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG, METODE_PEMBAYARAN.TIPE_PEMBAYARAN')
                ->join('TIKET', 'TIKET.ID_TIKET = DETAIL_PEMBAYARAN.ID_TIKET', 'left')
                ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                ->join('PEMBAYARAN', 'PEMBAYARAN.ID_PEMBAYARAN = DETAIL_PEMBAYARAN.ID_PEMBAYARAN', 'left')
                ->join('METODE_PEMBAYARAN', 'METODE_PEMBAYARAN.ID_METODE = PEMBAYARAN.ID_METODE', 'left')
                ->where('TGL_BAYAR >=', $start . ' 00:00:00')
                ->where('TGL_BAYAR <=', $end . ' 23:59:59')
                ->orderBy('TGL_BAYAR', 'DESC')
                ->findAll()
        ];

        return view('laporan/penjualan', $data);
    }

    public function manifest()
    {
        $penerbanganModel = new PenerbanganModel();
        $idFlight = $this->request->getGet('id_penerbangan');

        $manifest = [];
        $selectedFlight = null;

        if ($idFlight) {
            $tiketModel = new TiketModel();
            $manifest = $tiketModel->select('TIKET.*, PENUMPANG.NAMA_PENUMPANG, PENUMPANG.NO_IDENTITAS, PENUMPANG.JENIS_KELAMIN, CHECKIN.WAKTU_CHECKIN, KURSI.NO_KURSI2')
                ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                ->join('CHECKIN', 'CHECKIN.ID_TIKET = TIKET.ID_TIKET', 'left')
                ->join('KURSI', 'KURSI.ID_KURSI = CHECKIN.ID_KURSI', 'left')
                ->where('TIKET.ID_PENERBANGAN', $idFlight)
                ->findAll();
            
            $selectedFlight = $penerbanganModel->getWithRelations();
            // Filter to find the specific one
            $selectedFlight = array_filter($selectedFlight, function($f) use ($idFlight) {
                return $f['ID_PENERBANGAN'] == $idFlight;
            });
            $selectedFlight = reset($selectedFlight);
        }

        $data = [
            'title'          => 'Laporan Manifest Penumpang',
            'penerbangan'    => $penerbanganModel->getWithRelations(),
            'manifest'       => $manifest,
            'selectedFlight' => $selectedFlight
        ];

        return view('laporan/manifest', $data);
    }
}
