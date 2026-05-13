<?php

namespace App\Controllers;

use App\Models\PenerbanganModel;
use App\Models\PesawatModel;
use App\Models\GateModel;

class Penerbangan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PenerbanganModel();
    }

    public function index()
    {
        $data = [
            'title'       => 'Data Penerbangan',
            'penerbangan' => $this->model->getWithRelations(),
        ];
        return view('penerbangan/index', $data);
    }

    public function create()
    {
        $pesawatModel = new PesawatModel();
        $gateModel    = new GateModel();
        $data = [
            'title'   => 'Tambah Penerbangan',
            'pesawat' => $pesawatModel->getWithMaskapai(),
            'gates'   => $gateModel->findAll(),
        ];
        return view('penerbangan/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_PESAWAT'        => $this->request->getPost('id_pesawat'),
            'ID_GATE'           => $this->request->getPost('id_gate'),
            'TANGGAL_BERANGKAT' => $this->request->getPost('tanggal_berangkat'),
            'WAKTU_BERANGKAT'   => $this->request->getPost('waktu_berangkat'),
            'KOTA_ASAL'         => $this->request->getPost('kota_asal'),
            'KOTA_TUJUAN'       => $this->request->getPost('kota_tujuan'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/penerbangan')->with('success', 'Data penerbangan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penerbangan = $this->model->find($id);
        if (!$penerbangan) return redirect()->to('/penerbangan')->with('error', 'Data tidak ditemukan.');

        $pesawatModel = new PesawatModel();
        $gateModel    = new GateModel();
        $data = [
            'title'       => 'Edit Penerbangan',
            'penerbangan' => $penerbangan,
            'pesawat'     => $pesawatModel->getWithMaskapai(),
            'gates'       => $gateModel->findAll(),
        ];
        return view('penerbangan/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'ID_PESAWAT'        => $this->request->getPost('id_pesawat'),
            'ID_GATE'           => $this->request->getPost('id_gate'),
            'TANGGAL_BERANGKAT' => $this->request->getPost('tanggal_berangkat'),
            'WAKTU_BERANGKAT'   => $this->request->getPost('waktu_berangkat'),
            'KOTA_ASAL'         => $this->request->getPost('kota_asal'),
            'KOTA_TUJUAN'       => $this->request->getPost('kota_tujuan'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/penerbangan')->with('success', 'Data penerbangan berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/penerbangan')->with('success', 'Data penerbangan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/penerbangan')->with('error', 'Gagal menghapus! Penerbangan ini sudah memiliki data tiket yang terjual.');
        }
    }
}
