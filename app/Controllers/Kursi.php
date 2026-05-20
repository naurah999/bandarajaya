<?php

namespace App\Controllers;

use App\Models\KursiModel;
use App\Models\PesawatModel;

class Kursi extends BaseController
{
    protected $model;

    public function __construct()
    {
        $this->model = new KursiModel();
    }

    public function index()
    {
        $penerbanganModel = new \App\Models\PenerbanganModel();
        $pesawatModel = new \App\Models\PesawatModel();
        
        $flights = $penerbanganModel->getWithRelations();
        
        $selectedFlightId = $this->request->getVar('id_penerbangan');
        
        // Default to the first flight if none selected
        if (empty($selectedFlightId) && !empty($flights)) {
            $selectedFlightId = $flights[0]['ID_PENERBANGAN'];
        }
        
        $selectedFlight = null;
        if (!empty($selectedFlightId)) {
            foreach ($flights as $f) {
                if ($f['ID_PENERBANGAN'] == $selectedFlightId) {
                    $selectedFlight = $f;
                    break;
                }
            }
        }
        
        $seats = [];
        $occupiedMap = [];
        $pesawat = null;
        
        if ($selectedFlight) {
            $idPesawat = $selectedFlight['ID_PESAWAT'];
            $pesawat = $pesawatModel->find($idPesawat);
            
            // Get all configured seats for this plane
            $seats = $this->model->where('ID_PESAWAT', $idPesawat)
                                 ->orderBy('NO_KURSI2', 'ASC')
                                 ->findAll();
                                 
            // Get occupied seats and passenger details for this flight
            $occupied = $this->model->db->table('CHECKIN')
                ->select('CHECKIN.ID_KURSI, PENUMPANG.NAMA_PENUMPANG, TIKET.NOMER_TIKET')
                ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET')
                ->join('PENUMPANG', 'PENUMPANG.ID_PENUMPANG = TIKET.ID_PENUMPANG')
                ->where('TIKET.ID_PENERBANGAN', $selectedFlightId)
                ->get()
                ->getResultArray();
                
            foreach ($occupied as $occ) {
                $occupiedMap[$occ['ID_KURSI']] = [
                    'nama_penumpang' => $occ['NAMA_PENUMPANG'],
                    'nomer_tiket'    => $occ['NOMER_TIKET']
                ];
            }
        }
        
        $data = [
            'title'            => 'Peta & Data Kursi Pesawat',
            'flights'          => $flights,
            'selectedFlightId' => $selectedFlightId,
            'selectedFlight'   => $selectedFlight,
            'seats'            => $seats,
            'occupiedMap'      => $occupiedMap,
            'pesawat'          => $pesawat,
            'kursi'            => $this->model->getWithPesawat(),
        ];
        
        return view('kursi/index', $data);
    }

    public function create()
    {
        $pesawatModel = new PesawatModel();
        $data = [
            'title'   => 'Tambah Kursi',
            'pesawat' => $pesawatModel->getWithMaskapai(),
        ];
        return view('kursi/create', $data);
    }

    public function store()
    {
        $data = [
            'ID_PESAWAT'       => $this->request->getPost('id_pesawat'),
            'KELAS_PENERBANAN' => $this->request->getPost('kelas_penerbanan'),
            'NO_KURSI2'        => $this->request->getPost('no_kursi2'),
        ];

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/kursi')->with('success', 'Data kursi berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kursi = $this->model->find($id);
        if (!$kursi) return redirect()->to('/kursi')->with('error', 'Data tidak ditemukan.');

        $pesawatModel = new PesawatModel();
        $data = [
            'title'   => 'Edit Kursi',
            'kursi'   => $kursi,
            'pesawat' => $pesawatModel->getWithMaskapai(),
        ];
        return view('kursi/edit', $data);
    }

    public function update($id)
    {
        $data = [
            'ID_PESAWAT'       => $this->request->getPost('id_pesawat'),
            'KELAS_PENERBANAN' => $this->request->getPost('kelas_penerbanan'),
            'NO_KURSI2'        => $this->request->getPost('no_kursi2'),
        ];

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/kursi')->with('success', 'Data kursi berhasil diubah');
    }

    public function delete($id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/kursi')->with('success', 'Data kursi berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/kursi')->with('error', 'Gagal menghapus! Kursi ini sudah terisi oleh penumpang (Check-in).');
        }
    }
}
