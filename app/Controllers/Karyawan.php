<?php

namespace App\Controllers;

use App\Models\KaryawanModel;

class Karyawan extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KaryawanModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Karyawan',
            'karyawan' => $this->model->findAll()
        ];
        return view('karyawan/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Karyawan'];
        return view('karyawan/create', $data);
    }

    public function store()
    {
        $data = [
            'NAMA_KARYAWAN' => $this->request->getPost('nama_karyawan'),
            'JABATAN'       => $this->request->getPost('jabatan'),
            'NO_TELP'       => $this->request->getPost('no_telp'),
            'STATUS_KERJA'  => $this->request->getPost('status_kerja') ?? 'Aktif',
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil ditambahkan');
    }

    public function edit(int $id)
    {
        $karyawan = $this->model->find($id);
        if (!$karyawan) return redirect()->to('/karyawan')->with('error', 'Data tidak ditemukan.');

        $data = [
            'title'    => 'Edit Karyawan',
            'karyawan' => $karyawan
        ];
        return view('karyawan/edit', $data);
    }

    public function update(int $id)
    {
        $data = [
            'NAMA_KARYAWAN' => $this->request->getPost('nama_karyawan'),
            'JABATAN'       => $this->request->getPost('jabatan'),
            'NO_TELP'       => $this->request->getPost('no_telp'),
            'STATUS_KERJA'  => $this->request->getPost('status_kerja'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil diubah');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/karyawan')->with('success', 'Data karyawan berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/karyawan')->with('error', 'Gagal menghapus data karyawan.');
        }
    }
}
