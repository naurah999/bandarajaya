<?php

namespace App\Controllers;

use App\Models\KursiModel;
use App\Models\PesawatModel;

class Kursi extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KursiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Kursi',
            'kursi' => $this->model->getWithPesawat(),
        ];
        return view('kursi/index', $data);
    }

    public function create()
    {
        $pesawatModel = new PesawatModel();
        $data = [
            'title'   => 'Tambah Kursi',
            'pesawat' => $pesawatModel->getWithMaskapai(),
        ];
        return view('kursi/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_PESAWAT'       => $this->request->getPost('id_pesawat'),
            'KELAS_PENERBANAN' => $this->request->getPost('kelas_penerbanan'),
            'NO_KURSI2'        => $this->request->getPost('no_kursi2'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/kursi')->with('success', 'Data kursi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kursi = $this->model->find($id);
        if (!$kursi) return redirect()->to('/kursi')->with('error', 'Data tidak ditemukan.');

        $pesawatModel = new PesawatModel();
        $data = [
            'title'   => 'Edit Kursi',
            'kursi'   => $kursi,
            'pesawat' => $pesawatModel->getWithMaskapai(),
        ];
        return view('kursi/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'ID_PESAWAT'       => $this->request->getPost('id_pesawat'),
            'KELAS_PENERBANAN' => $this->request->getPost('kelas_penerbanan'),
            'NO_KURSI2'        => $this->request->getPost('no_kursi2'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/kursi')->with('success', 'Data kursi berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/kursi')->with('success', 'Data kursi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/kursi')->with('error', 'Gagal menghapus! Kursi ini sudah terisi oleh penumpang (Check-in).');
        }
    }
}
