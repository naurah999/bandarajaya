<?php

namespace App\Controllers;

use App\Models\PesawatModel;
use App\Models\MaskapaiModel;

class Pesawat extends BaseController
{
    /** @var PesawatModel */
    protected $model;

    public function __construct()
    {
        $this->model = new PesawatModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Pesawat',
            'pesawat' => $this->model->getWithMaskapai(),
        ];
        return view('pesawat/index', $data);
    }

    public function create()
    {
        $maskapaiModel = new MaskapaiModel();
        $data = [
            'title'    => 'Tambah Pesawat',
            'maskapai' => $maskapaiModel->findAll(),
        ];
        return view('pesawat/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_MASKAPAI'    => $this->request->getPost('id_maskapai'),
            'KODE_PESAWAT'   => $this->request->getPost('kode_pesawat'),
            'TIPE_PESAWAT'   => $this->request->getPost('tipe_pesawat'),
            'KAPASITAS'      => $this->request->getPost('kapasitas'),
            'TAHUN_PRODUKSI' => $this->request->getPost('tahun_produksi'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }

        $pesawatId = $this->model->getInsertID();
        $kapasitas = (int)$data['KAPASITAS'];
        
        $kursiModel = new \App\Models\KursiModel();
        $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        
        for ($i = 0; $i < $kapasitas; $i++) {
            $row = floor($i / 6) + 1;
            $letter = $letters[$i % 6];
            $noKursi = $row . $letter;
            
            $kursiModel->insert([
                'ID_PESAWAT'       => $pesawatId,
                'NO_KURSI2'        => $noKursi,
                'KELAS_PENERBANAN' => 'Ekonomi', // Default
                'STATUS_KURSI'     => 'Tersedia'
            ]);
        }

        return redirect()->to('/pesawat')->with('success', 'Data pesawat dan ' . $kapasitas . ' kursi berhasil ditambahkan otomatis.');
    }

    public function edit(int $id)
    {
        $maskapaiModel = new MaskapaiModel();
        $data = [
            'title'    => 'Edit Pesawat',
            'pesawat'  => $this->model->find($id),
            'maskapai' => $maskapaiModel->findAll(),
        ];
        return view('pesawat/edit', $data);
    }

    public function update(int $id)
    {
        $data = [
            'ID_MASKAPAI'    => $this->request->getPost('id_maskapai'),
            'KODE_PESAWAT'   => $this->request->getPost('kode_pesawat'),
            'TIPE_PESAWAT'   => $this->request->getPost('tipe_pesawat'),
            'KAPASITAS'      => $this->request->getPost('kapasitas'),
            'TAHUN_PRODUKSI' => $this->request->getPost('tahun_produksi'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/pesawat')->with('success', 'Data pesawat berhasil diubah');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/pesawat')->with('success', 'Data pesawat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/pesawat')->with('error', 'Gagal menghapus! Data pesawat ini masih memiliki data kursi atau penerbangan.');
        }
    }
}
