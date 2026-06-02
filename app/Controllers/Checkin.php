<?php

namespace App\Controllers;

use App\Models\CheckinModel;
use App\Models\TiketModel;
use App\Models\KursiModel;

class Checkin extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new CheckinModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Data Check-in',
            'checkins' => $this->model->getWithRelations(),
        ];
        return view('checkin/index', $data);
    }

    public function getAvailableSeats(int $idTiket)
    {
        $tiketModel = new TiketModel();
        $kursiModel = new KursiModel();
        
        $tiket = $tiketModel->find($idTiket);
        if (!$tiket) {
            return $this->response->setJSON(['seats' => [], 'occupiedIds' => []]);
        }

        $penerbanganModel = new \App\Models\PenerbanganModel();
        $penerbangan = $penerbanganModel->find($tiket['ID_PENERBANGAN']);
        
        if (!$penerbangan) {
            return $this->response->setJSON(['seats' => [], 'occupiedIds' => []]);
        }

        // Get all seats of this aircraft
        $seats = $kursiModel->where('ID_PESAWAT', $penerbangan['ID_PESAWAT'])
                            ->orderBy('NO_KURSI2', 'ASC')
                            ->findAll();

        // Get class colors for this catalog
        $classColors = [];
        $pesawatModel = new \App\Models\PesawatModel();
        $plane = $pesawatModel->find($penerbangan['ID_PESAWAT']);
        if ($plane && !empty($plane['ID_CATALOG'])) {
            $kelasModel = new \App\Models\CatalogKelasModel();
            $classes = $kelasModel->where('ID_CATALOG', $plane['ID_CATALOG'])->findAll();
            foreach ($classes as $cl) {
                $classColors[$cl['NAMA_KELAS']] = $cl['WARNA_KELAS'];
            }
        }

        // Get occupied seat IDs
        $occupied = $this->model->db->table('CHECKIN')
            ->select('ID_KURSI')
            ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET')
            ->where('TIKET.ID_PENERBANGAN', $tiket['ID_PENERBANGAN'])
            ->get()
            ->getResultArray();
            
        $occupiedIds = array_map('intval', array_column($occupied, 'ID_KURSI'));

        return $this->response->setJSON([
            'seats' => $seats,
            'occupiedIds' => $occupiedIds,
            'classColors' => $classColors
        ]);
    }

    public function getAllSeats(int $idTiket)
    {
        $tiketModel = new TiketModel();
        $kursiModel = new KursiModel();
        
        $tiket = $tiketModel->find($idTiket);
        if (!$tiket) {
            return $this->response->setJSON([]);
        }

        $penerbanganModel = new \App\Models\PenerbanganModel();
        $penerbangan = $penerbanganModel->find($tiket['ID_PENERBANGAN']);
        
        if (!$penerbangan) {
            return $this->response->setJSON([]);
        }

        // Get ALL seats for this plane
        $allSeats = $kursiModel->where('ID_PESAWAT', $penerbangan['ID_PESAWAT'])
                               ->orderBy('NO_KURSI2', 'ASC')
                               ->findAll();

        // Get occupied seat IDs for this flight
        $db = \Config\Database::connect();
        $occupied = $db->table('CHECKIN')
            ->select('CHECKIN.ID_KURSI')
            ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET')
            ->where('TIKET.ID_PENERBANGAN', $tiket['ID_PENERBANGAN'])
            ->get()
            ->getResultArray();
        $occupiedIds = array_column($occupied, 'ID_KURSI');

        // Mark each seat as occupied or available
        foreach ($allSeats as &$seat) {
            $seat['occupied'] = in_array($seat['ID_KURSI'], $occupiedIds);
        }

        return $this->response->setJSON($allSeats);
    }

    public function create()
    {
        $tiketModel = new TiketModel();
        $kursiModel = new KursiModel();
        $data = [
            'title'  => 'Proses Check-in',
            'tikets' => $tiketModel->getWithRelations(),
            'kursi'  => $kursiModel->getWithPesawat(),
        ];
        return view('checkin/create', $data);
    }

    public function store()
    {
        $this->model->insert([
            'ID_TIKET'      => $this->request->getPost('id_tiket'),
            'ID_KURSI'      => $this->request->getPost('id_kursi'),
            'WAKTU_CHECKIN'  => date('Y-m-d H:i:s'),
        ]);
        return redirect()->to('/checkin')->with('success', 'Check-in berhasil diproses');
    }

    public function edit($id)
    {
        $tiketModel = new TiketModel();
        $kursiModel = new KursiModel();
        $data = [
            'title'   => 'Edit Check-in',
            'checkin' => $this->model->find($id),
            'tikets'  => $tiketModel->getWithRelations(),
            'kursi'   => $kursiModel->getWithPesawat(),
        ];
        return view('checkin/edit', $data);
    }

    public function update($id)
    {
        $this->model->update($id, [
            'ID_TIKET' => $this->request->getPost('id_tiket'),
            'ID_KURSI' => $this->request->getPost('id_kursi'),
        ]);
        return redirect()->to('/checkin')->with('success', 'Data check-in berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/checkin')->with('success', 'Data check-in berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/checkin')->with('error', 'Gagal menghapus! Data check-in ini masih terkait dengan bagasi atau boarding pass.');
        }
    }
}
