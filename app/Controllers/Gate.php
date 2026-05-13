<?php

namespace App\Controllers;

use App\Models\GateModel;

class Gate extends BaseController
{
    /** @var GateModel */
    protected $model;

    public function __construct()
    {
        $this->model = new GateModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Gate',
            'gates' => $this->model->findAll()
        ];
        return view('gate/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Gate'];
        return view('gate/create', $data);
    }

    public function store()
    {
        $data = [
            'NOMOR_GATE' => $this->request->getPost('nomor_gate'),
            'TERMINAL'   => $this->request->getPost('terminal'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/gate')->with('success', 'Gate berhasil ditambahkan.');
    }

    public function edit(int $id)
    {
        $gate = $this->model->find($id);
        if (!$gate) return redirect()->to('/gate')->with('error', 'Gate tidak ditemukan.');

        $data = [
            'title' => 'Edit Gate',
            'gate'  => $gate
        ];
        return view('gate/edit', $data);
    }

    public function update(int $id)
    {
        $data = [
            'NOMOR_GATE' => $this->request->getPost('nomor_gate'),
            'TERMINAL'   => $this->request->getPost('terminal'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/gate')->with('success', 'Gate berhasil diubah.');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/gate')->with('success', 'Gate berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/gate')->with('error', 'Gagal menghapus! Gate ini masih digunakan di jadwal penerbangan.');
        }
    }
}
