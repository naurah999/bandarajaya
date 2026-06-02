<?php

namespace App\Controllers;

use App\Models\PembayaranModel;
use App\Models\MetodePembayaranModel;

class Pembayaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PembayaranModel();
    }

    public function index()
    {
        $data = [
            'title'       => 'Data Pembayaran',
            'pembayaran'  => $this->model->getWithMetode(),
        ];
        return view('pembayaran/index', $data);
    }

    public function create()
    {
        $metodeModel = new MetodePembayaranModel();
        $tiketModel = new \App\Models\TiketModel();
        $data = [
            'title'  => 'Tambah Pembayaran',
            'metode' => $metodeModel->findAll(),
            'tikets' => $tiketModel->getUnpaidTikets()
        ];
        return view('pembayaran/create', $data);
    }

    public function store()
    {
        $tiketIds = $this->request->getPost('id_tiket');
        if (empty($tiketIds)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal satu tiket.');
        }

        $tiketModel = new \App\Models\TiketModel();
        $detailModel = new \App\Models\DetailPembayaranModel();
        
        $tikets = $tiketModel->whereIn('ID_TIKET', $tiketIds)->findAll();
        $totalHarga = 0;
        foreach ($tikets as $t) {
            $totalHarga += $t['HARGA'];
        }

        $pembayaranId = $this->model->insert([
            'ID_METODE'    => $this->request->getPost('id_metode'),
            'JUMLAH_TIKET' => count($tiketIds),
            'TOTAL_HARGA'  => $totalHarga,
        ]);

        if (!$pembayaranId) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan pembayaran.');
        }

        foreach ($tikets as $t) {
            $idMembayar = $detailModel->insert([
                'ID_PEMBAYARAN'     => $pembayaranId,
                'ID_TIKET'          => $t['ID_TIKET'],
                'TGL_BAYAR'         => date('Y-m-d H:i:s'),
                'JUMLAH_BAYAR'      => $t['HARGA'],
                'STATUS_PEMBAYARAN' => 'Lunas'
            ]);

            // Fix relasi TIKET.ID_MEMBAYAR
            $tiketModel->update($t['ID_TIKET'], ['ID_MEMBAYAR' => $idMembayar]);
        }

        return redirect()->to('/pembayaran')->with('success', 'Data pembayaran dan detail berhasil disimpan secara otomatis.');
    }

    public function edit($id)
    {
        $metodeModel = new MetodePembayaranModel();
        $data = [
            'title'       => 'Edit Pembayaran',
            'pembayaran'  => $this->model->find($id),
            'metode'      => $metodeModel->findAll(),
        ];
        return view('pembayaran/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'ID_METODE'    => $this->request->getPost('id_metode'),
            'JUMLAH_TIKET' => $this->request->getPost('jumlah_tiket'),
            'TOTAL_HARGA'  => $this->request->getPost('total_harga'),
        ]);
        return redirect()->to('/pembayaran')->with('success', 'Data pembayaran berhasil diubah');
    }

    public function delete($id)
    {
        $db = \Config\Database::connect();
        
        try {
            $db->transStart();
            
            $detailModel = new \App\Models\DetailPembayaranModel();
            $tiketModel = new \App\Models\TiketModel();
            
            $details = $detailModel->where('ID_PEMBAYARAN', $id)->findAll();
            
            foreach ($details as $detail) {
                // Set ID_MEMBAYAR di TIKET menjadi null kembali (jadi belum dibayar)
                $tiketModel->where('ID_MEMBAYAR', $detail['ID_MEMBAYAR'])
                           ->set(['ID_MEMBAYAR' => null])
                           ->update();
            }
            
            // Hapus detail pembayaran
            $detailModel->where('ID_PEMBAYARAN', $id)->delete();
            
            // Hapus record pembayaran utama
            $this->model->delete($id);
            
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return redirect()->to('/pembayaran')->with('error', 'Gagal menghapus data pembayaran.');
            }
            
            return redirect()->to('/pembayaran')->with('success', 'Data pembayaran berhasil dihapus. Status tiket kembali menjadi belum dibayar.');
        } catch (\Exception $e) {
            return redirect()->to('/pembayaran')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
