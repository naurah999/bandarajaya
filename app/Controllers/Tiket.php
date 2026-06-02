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
        // Auto generate Nomor Tiket if empty
        $nomerTiket = $this->request->getPost('nomer_tiket');
        if (empty($nomerTiket)) {
            $nomerTiket = 'TKT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 4));
        }

        $idPenerbangan = $this->request->getPost('id_penerbangan');
        $harga = $this->request->getPost('harga') ?? 0;

        $data = [
            'ID_PENUMPANG'   => $this->request->getPost('id_penumpang'),
            'ID_PENERBANGAN' => $idPenerbangan,
            'NOMER_TIKET'    => $nomerTiket,
            'KELAS_TIKET'    => $this->request->getPost('kelas_tiket'),
            'HARGA'          => $harga,
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
        $idPenerbangan = $this->request->getPost('id_penerbangan');
        $harga = $this->request->getPost('harga') ?? 0;

        $data = [
            'ID_PENUMPANG'   => $this->request->getPost('id_penumpang'),
            'ID_PENERBANGAN' => $idPenerbangan,
            'NOMER_TIKET'    => $this->request->getPost('nomer_tiket'),
            'KELAS_TIKET'    => $this->request->getPost('kelas_tiket'),
            'HARGA'          => $harga,
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

    public function getClasses(int $idPenerbangan)
    {
        $db = \Config\Database::connect();
        $flight = $db->table('PENERBANGAN')
            ->join('PESAWAT', 'PESAWAT.ID_PESAWAT = PENERBANGAN.ID_PESAWAT', 'left')
            ->where('ID_PENERBANGAN', $idPenerbangan)
            ->get()->getRowArray();
            
        if (!$flight || empty($flight['ID_CATALOG'])) {
            return $this->response->setJSON([]);
        }
        
        $classes = $db->table('CATALOG_KELAS')
            ->where('ID_CATALOG', $flight['ID_CATALOG'])
            ->get()->getResultArray();
            
        return $this->response->setJSON($classes);
    }
}
