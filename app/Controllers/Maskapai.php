<?php

namespace App\Controllers;

use App\Models\MaskapaiModel;

class Maskapai extends BaseController
{
    /** @var MaskapaiModel */
    protected $model;

    public function __construct()
    {
        $this->model = new MaskapaiModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Maskapai',
            'maskapai' => $this->model->findAll(),
        ];
        return view('maskapai/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Maskapai'];
        return view('maskapai/create', $data);
    }

    public function store()
    {
        $data = [
            'NAMA_MASKAPAI' => $this->request->getPost('nama_maskapai'),
            'KODE_MASKAPAI' => $this->request->getPost('kode_maskapai'),
            'NEGARA_ASAL'   => $this->request->getPost('negara_asal'),
            'NO_KONTAK'     => $this->request->getPost('no_kontak'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/maskapai')->with('success', 'Data maskapai berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $maskapai = $this->model->find($id);
        if (!$maskapai) return redirect()->to('/maskapai')->with('error', 'Data tidak ditemukan.');

        $data = [
            'title'    => 'Edit Maskapai',
            'maskapai' => $maskapai,
        ];
        return view('maskapai/edit', $data);
    }

    public function update(int $id)
    {
        $data = [
            'NAMA_MASKAPAI' => $this->request->getPost('nama_maskapai'),
            'KODE_MASKAPAI' => $this->request->getPost('kode_maskapai'),
            'NEGARA_ASAL'   => $this->request->getPost('negara_asal'),
            'NO_KONTAK'     => $this->request->getPost('no_kontak'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/maskapai')->with('success', 'Data maskapai berhasil diubah');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/maskapai')->with('success', 'Data maskapai berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/maskapai')->with('error', 'Data gagal dihapus karena masih terkait dengan data lain.');
        }
    }
}
