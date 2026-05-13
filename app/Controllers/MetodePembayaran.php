<?php

namespace App\Controllers;

use App\Models\MetodePembayaranModel;

class MetodePembayaran extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new MetodePembayaranModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Metode Pembayaran',
            'metode' => $this->model->findAll(),
        ];
        return view('metode_pembayaran/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Metode Pembayaran'];
        return view('metode_pembayaran/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'TIPE_PEMBAYARAN' => $this->request->getPost('tipe_pembayaran'),
        ]);
        return redirect()->to('/metode-pembayaran')->with('success', 'Metode pembayaran berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data = [
            'title'  => 'Edit Metode Pembayaran',
            'metode' => $this->model->find($id),
        ];
        return view('metode_pembayaran/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'TIPE_PEMBAYARAN' => $this->request->getPost('tipe_pembayaran'),
        ]);
        return redirect()->to('/metode-pembayaran')->with('success', 'Metode pembayaran berhasil diubah');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/metode-pembayaran')->with('success', 'Metode pembayaran berhasil dihapus');
    }
}
