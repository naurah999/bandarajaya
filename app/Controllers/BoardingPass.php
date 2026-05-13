<?php

namespace App\Controllers;

use App\Models\BoardingPassModel;
use App\Models\CheckinModel;
use App\Models\GateModel;

class BoardingPass extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new BoardingPassModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Boarding Pass',
            'boarding' => $this->model->getWithRelations(),
        ];
        return view('boardingpass/index', $data);
    }

    public function create()
    {
        $checkinModel = new CheckinModel();
        $data = [
            'title'    => 'Cetak Boarding Pass',
            'checkins' => $checkinModel->getWithRelations(),
        ];
        return view('boardingpass/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'ID_CHECKIN'      => $this->request->getPost('id_checkin'),
            'ID_GATE'         => $this->request->getPost('id_gate'),
            'WAKTU_BOARDING'  => $this->request->getPost('waktu_boarding'),
        ]);
        return redirect()->to('/boardingpass')->with('success', 'Boarding pass berhasil dicetak');
    }

    public function edit($id)
    {
        $checkinModel = new CheckinModel();
        $data = [
            'title'    => 'Edit Boarding Pass',
            'boarding' => $this->model->find($id),
            'checkins' => $checkinModel->getWithRelations(),
        ];
        return view('boardingpass/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'ID_CHECKIN'      => $this->request->getPost('id_checkin'),
            'ID_GATE'         => $this->request->getPost('id_gate'),
            'WAKTU_BOARDING'  => $this->request->getPost('waktu_boarding'),
        ]);
        return redirect()->to('/boardingpass')->with('success', 'Boarding pass berhasil diubah');
    }

    public function delete($id)
    {
        $this->model->delete($id);
        return redirect()->to('/boardingpass')->with('success', 'Boarding pass berhasil dihapus');
    }
}
