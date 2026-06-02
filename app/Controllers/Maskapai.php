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

    /**
     * Halaman profil maskapai. Jika belum ada data, tampilkan form setup.
     */
    public function index()
    {
        $maskapai = $this->model->first();

        if (!$maskapai) {
            // Belum ada data maskapai, tampilkan form setup
            return view('maskapai/setup', ['title' => 'Setup Maskapai']);
        }

        $data = [
            'title'    => 'Profil Maskapai',
            'maskapai' => $maskapai,
        ];
        return view('maskapai/profile', $data);
    }

    /**
     * Proses penyimpanan data maskapai pertama kali (setup awal)
     */
    public function setup()
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
        return redirect()->to('/maskapai')->with('success', 'Profil maskapai berhasil disimpan! Selamat datang.');
    }

    /**
     * Form edit profil maskapai
     */
    public function edit()
    {
        $maskapai = $this->model->first();
        if (!$maskapai) return redirect()->to('/maskapai')->with('error', 'Data maskapai belum tersedia.');

        $data = [
            'title'    => 'Edit Profil Maskapai',
            'maskapai' => $maskapai,
        ];
        return view('maskapai/edit', $data);
    }

    /**
     * Proses update profil maskapai
     */
    public function update()
    {
        $maskapai = $this->model->first();
        if (!$maskapai) return redirect()->to('/maskapai')->with('error', 'Data maskapai belum tersedia.');

        $data = [
            'NAMA_MASKAPAI' => $this->request->getPost('nama_maskapai'),
            'KODE_MASKAPAI' => $this->request->getPost('kode_maskapai'),
            'NEGARA_ASAL'   => $this->request->getPost('negara_asal'),
            'NO_KONTAK'     => $this->request->getPost('no_kontak'),
        ];

        if (!$this->model->update($maskapai['ID_MASKAPAI'], $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/maskapai')->with('success', 'Profil maskapai berhasil diperbarui');
    }
}
