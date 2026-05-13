<?php

namespace App\Controllers;

use App\Models\TiketModel;
use App\Models\PenumpangModel;
use App\Models\PenerbanganModel;

class Tiket extends BaseController
{
    /** @var TiketModel */
    protected $model;

    public function __construct()
    {
        $this->model = new TiketModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Daftar Tiket',
            'tikets' => $this->model->getWithRelations()
        ];
        return view('tiket/index', $data);
    }

    public function create()
    {
        $penumpangModel = new PenumpangModel();
        $penerbanganModel = new PenerbanganModel();
        
        $data = [
            'title'        => 'Buat Tiket Baru',
            'penumpang'    => $penumpangModel->findAll(),
            'penerbangan'  => $penerbanganModel->getWithRelations()
        ];
        return view('tiket/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_PENUMPANG'   => $this->request->getPost('id_penumpang'),
            'ID_PENERBANGAN' => $this->request->getPost('id_penerbangan'),
            'NOMER_TIKET'    => $this->request->getPost('nomer_tiket'),
            'HARGA'          => $this->request->getPost('harga'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/tiket')->with('success', 'Tiket berhasil dibuat.');
    }

    public function edit(int $id)
    {
        $tiket = $this->model->find($id);
        if (!$tiket) return redirect()->to('/tiket')->with('error', 'Tiket tidak ditemukan.');

        $penumpangModel = new PenumpangModel();
        $penerbanganModel = new PenerbanganModel();

        $data = [
            'title'       => 'Edit Tiket',
            'tiket'       => $tiket,
            'penumpang'   => $penumpangModel->findAll(),
            'penerbangan' => $penerbanganModel->getWithRelations()
        ];
        return view('tiket/edit', $data);
    }

    public function update(int $id)
    {
        $data = [
            'ID_PENUMPANG'   => $this->request->getPost('id_penumpang'),
            'ID_PENERBANGAN' => $this->request->getPost('id_penerbangan'),
            'NOMER_TIKET'    => $this->request->getPost('nomer_tiket'),
            'HARGA'          => $this->request->getPost('harga'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/tiket')->with('success', 'Tiket berhasil diubah.');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/tiket')->with('success', 'Tiket berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/tiket')->with('error', 'Gagal menghapus! Tiket ini sudah masuk proses check-in atau pembayaran.');
        }
    }
}
