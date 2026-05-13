<?php

namespace App\Controllers;

use App\Models\DetailPembayaranModel;
use App\Models\PembayaranModel;
use App\Models\TiketModel;

class DetailPembayaran extends BaseController
{
    /** @var DetailPembayaranModel */
    protected $model;

    /** @var PembayaranModel */
    protected $pembayaranModel;

    /** @var TiketModel */
    protected $tiketModel;

    public function __construct()
    {
        $this->model = new DetailPembayaranModel();
        $this->pembayaranModel = new PembayaranModel();
        $this->tiketModel = new TiketModel();
    }

    public function index()
    {
        $idPembayaran = $this->request->getGet('pembayaran');
        
        if ($idPembayaran) {
            $details = $this->model->select('DETAIL_PEMBAYARAN.*, PEMBAYARAN.TOTAL_HARGA, METODE_PEMBAYARAN.TIPE_PEMBAYARAN, TIKET.NOMER_TIKET, PENUMPANG.NAMA_PENUMPANG')
                ->join('PEMBAYARAN', 'PEMBAYARAN.ID_PEMBAYARAN = DETAIL_PEMBAYARAN.ID_PEMBAYARAN', 'left')
                ->join('METODE_PEMBAYARAN', 'METODE_PEMBAYARAN.ID_METODE = PEMBAYARAN.ID_METODE', 'left')
                ->join('TIKET', 'TIKET.ID_TIKET = DETAIL_PEMBAYARAN.ID_TIKET', 'left')
                ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG', 'left')
                ->where('DETAIL_PEMBAYARAN.ID_PEMBAYARAN', $idPembayaran)
                ->findAll();
            $title = 'Detail Tiket untuk Transaksi TRX-' . $idPembayaran;
        } else {
            $details = $this->model->getWithRelations();
            $title = 'Daftar Semua Detail Pembayaran';
        }

        $data = [
            'title' => $title,
            'detail' => $details
        ];
        return view('detail_pembayaran/index', $data);
    }

    public function create()
    {
        $data = [
            'title'      => 'Catat Detail Pelunasan',
            'pembayaran' => $this->pembayaranModel->getWithMetode(),
            'tikets'     => $this->tiketModel->getWithRelations()
        ];
        return view('detail_pembayaran/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_PEMBAYARAN'     => $this->request->getPost('id_pembayaran'),
            'ID_TIKET'          => $this->request->getPost('id_tiket'),
            'JUMLAH_BAYAR'      => $this->request->getPost('jumlah_bayar'),
            'STATUS_PEMBAYARAN' => $this->request->getPost('status_pembayaran'),
            'TGL_BAYAR'         => date('Y-m-d H:i:s'),
        ];

        $this->model->insert($data);
        return redirect()->to('/detail-pembayaran')->with('success', 'Detail pembayaran berhasil dicatat.');
    }

    public function edit(int $id)
    {
        $data = [
            'title'      => 'Edit Detail Pembayaran',
            'detail'     => $this->model->find($id),
            'pembayaran' => $this->pembayaranModel->getWithMetode(),
            'tikets'     => $this->tiketModel->getWithRelations()
        ];
        return view('detail_pembayaran/edit', $data);
    }

    public function update(int $id)
    {
        $this->model->update($id, [
            'ID_PEMBAYARAN'     => $this->request->getPost('id_pembayaran'),
            'ID_TIKET'          => $this->request->getPost('id_tiket'),
            'JUMLAH_BAYAR'      => $this->request->getPost('jumlah_bayar'),
            'STATUS_PEMBAYARAN' => $this->request->getPost('status_pembayaran'),
        ]);
        return redirect()->to('/detail-pembayaran')->with('success', 'Detail pembayaran berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);
        return redirect()->to('/detail-pembayaran')->with('success', 'Detail pembayaran berhasil dihapus.');
    }
}
