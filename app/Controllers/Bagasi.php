<?php

namespace App\Controllers;

use App\Models\BagasiModel;
use App\Models\CheckinModel;

class Bagasi extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new BagasiModel();
    }

    public function index()
    {
        $data = [
            'title'  => 'Data Bagasi',
            'bagasi' => $this->model->getWithRelations(),
        ];
        return view('bagasi/index', $data);
    }

    public function create()
    {
        $checkinModel = new CheckinModel();
        $data = [
            'title'    => 'Tambah Bagasi',
            'checkins' => $checkinModel->getWithRelations(),
        ];
        return view('bagasi/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'ID_CHECKIN'    => $this->request->getPost('id_checkin'),
            'BERAT_BAGASI'  => $this->request->getPost('berat_bagasi'),
            'STATUS_BAGASI' => $this->request->getPost('status_bagasi'),
        ]);
        return redirect()->to('/bagasi')->with('success', 'Data bagasi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $checkinModel = new CheckinModel();
        $data = [
            'title'    => 'Edit Bagasi',
            'bagasi'   => $this->model->find($id),
            'checkins' => $checkinModel->getWithRelations(),
        ];
        return view('bagasi/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'ID_CHECKIN'    => $this->request->getPost('id_checkin'),
            'BERAT_BAGASI'  => $this->request->getPost('berat_bagasi'),
            'STATUS_BAGASI' => $this->request->getPost('status_bagasi'),
        ]);
        return redirect()->to('/bagasi')->with('success', 'Data bagasi berhasil diubah');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/bagasi')->with('success', 'Data bagasi berhasil dihapus');
    }
}
