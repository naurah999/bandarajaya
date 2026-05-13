<?php

namespace App\Controllers;

use App\Models\PenumpangModel;

class Penumpang extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new PenumpangModel();
    }

    public function index()
    {
        $data = [
            'title'     => 'Data Penumpang',
            'penumpang' => $this->model->findAll(),
        ];
        return view('penumpang/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Penumpang'];
        return view('penumpang/create', $data);
    }

    public function store()
    {
        $data = [
            'NAMA_PENUMPANG' => $this->request->getPost('nama_penumpang'),
            'NO_IDENTITAS'   => $this->request->getPost('no_identitas'),
            'JENIS_KELAMIN'  => $this->request->getPost('jenis_kelamin'),
            'TANGGAL_LAHIR'  => $this->request->getPost('tanggal_lahir'),
            'NO_TELP'        => $this->request->getPost('no_telp'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/penumpang')->with('success', 'Data penumpang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $penumpang = $this->model->find($id);
        if (!$penumpang) return redirect()->to('/penumpang')->with('error', 'Data tidak ditemukan.');

        $data = [
            'title'     => 'Edit Penumpang',
            'penumpang' => $penumpang,
        ];
        return view('penumpang/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'NAMA_PENUMPANG' => $this->request->getPost('nama_maskapai'), // Wait, check POST key
            'NO_IDENTITAS'   => $this->request->getPost('no_identitas'),
            'JENIS_KELAMIN'  => $this->request->getPost('jenis_kelamin'),
            'TANGGAL_LAHIR'  => $this->request->getPost('tanggal_lahir'),
            'NO_TELP'        => $this->request->getPost('no_telp'),
        ];
        // Wait, the POST key in store was nama_penumpang. I should be consistent.
        $data['NAMA_PENUMPANG'] = $this->request->getPost('nama_penumpang');

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/penumpang')->with('success', 'Data penumpang berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/penumpang')->with('success', 'Data penumpang berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/penumpang')->with('error', 'Gagal menghapus! Penumpang ini masih memiliki data tiket.');
        }
    }
}
