<?php

namespace App\Controllers;

use App\Models\PesawatModel;
use App\Models\MaskapaiModel;
use App\Models\CatalogPesawatModel;
use App\Models\CatalogKelasModel;
use App\Models\KursiModel;

class Pesawat extends BaseController
{
    /** @var PesawatModel */
    protected $model;

    public function __construct()
    {
        $this->model = new PesawatModel();
    }

    public function index()
    {
        $data = [
            'title'   => 'Data Pesawat',
            'pesawat' => $this->model->getWithCatalog(),
        ];
        return view('pesawat/index', $data);
    }

    public function create()
    {
        $catalogModel = new CatalogPesawatModel();
        $data = [
            'title'    => 'Tambah Pesawat',
            'catalogs' => $catalogModel->findAll(),
        ];
        return view('pesawat/create', $data);
    }

    public function store()
    {
        // Get maskapai ID automatically
        $maskapaiModel = new MaskapaiModel();
        $maskapai = $maskapaiModel->first();

        if (!$maskapai) {
            return redirect()->to('/maskapai')->with('error', 'Silakan setup profil maskapai terlebih dahulu.');
        }

        $catalogId = (int) $this->request->getPost('id_catalog');

        $data = [
            'ID_MASKAPAI'    => $maskapai['ID_MASKAPAI'],
            'ID_CATALOG'     => $catalogId,
            'KODE_PESAWAT'   => $this->request->getPost('kode_pesawat'),
            'TIPE_PESAWAT'   => '', // Will be filled from catalog
            'KAPASITAS'      => 0,  // Will be filled from catalog
            'TAHUN_PRODUKSI' => $this->request->getPost('tahun_produksi'),
            'STATUS_PESAWAT' => $this->request->getPost('status_pesawat') ?? 'Aktif',
        ];

        // Get catalog info
        $catalogModel = new CatalogPesawatModel();
        $catalog = $catalogModel->find($catalogId);
        if ($catalog) {
            $data['TIPE_PESAWAT'] = $catalog['TIPE_PESAWAT'];
            $data['KAPASITAS'] = $this->request->getPost('kapasitas') ? (int)$this->request->getPost('kapasitas') : $catalog['TOTAL_KAPASITAS'];
        }

        if (!$this->model->insert($data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }

        $pesawatId = $this->model->getInsertID();

        // Auto-generate seats from catalog
        $this->generateSeatsFromCatalog($pesawatId, $catalogId);

        return redirect()->to('/pesawat')->with('success', 'Pesawat berhasil ditambahkan. ' . ($catalog['TOTAL_KAPASITAS'] ?? 0) . ' kursi otomatis dibuat sesuai layout catalog.');
    }

    public function edit(int $id)
    {
        $pesawat = $this->model->find($id);
        if (!$pesawat) return redirect()->to('/pesawat')->with('error', 'Data tidak ditemukan.');

        $catalogModel = new CatalogPesawatModel();
        $data = [
            'title'    => 'Edit Pesawat',
            'pesawat'  => $pesawat,
            'catalogs' => $catalogModel->findAll(),
        ];
        return view('pesawat/edit', $data);
    }

    public function update(int $id)
    {
        $maskapaiModel = new MaskapaiModel();
        $maskapai = $maskapaiModel->first();

        $catalogId = (int) $this->request->getPost('id_catalog');

        $data = [
            'ID_MASKAPAI'    => $maskapai ? $maskapai['ID_MASKAPAI'] : null,
            'ID_CATALOG'     => $catalogId,
            'KODE_PESAWAT'   => $this->request->getPost('kode_pesawat'),
            'TAHUN_PRODUKSI' => $this->request->getPost('tahun_produksi'),
            'STATUS_PESAWAT' => $this->request->getPost('status_pesawat') ?? 'Aktif',
        ];

        // Get catalog info
        $catalogModel = new CatalogPesawatModel();
        $catalog = $catalogModel->find($catalogId);
        if ($catalog) {
            $data['TIPE_PESAWAT'] = $catalog['TIPE_PESAWAT'];
            $data['KAPASITAS'] = $this->request->getPost('kapasitas') ? (int)$this->request->getPost('kapasitas') : $catalog['TOTAL_KAPASITAS'];
        }

        if (!$this->model->update($id, $data)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }
        return redirect()->to('/pesawat')->with('success', 'Data pesawat berhasil diubah');
    }

    public function delete(int $id)
    {
        try {
            $this->model->delete($id);
            return redirect()->to('/pesawat')->with('success', 'Data pesawat berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->to('/pesawat')->with('error', 'Gagal menghapus! Data pesawat ini masih memiliki data kursi atau penerbangan.');
        }
    }

    /**
     * Generate seats from catalog layout + capacity
     */
    private function generateSeatsFromCatalog(int $pesawatId, int $catalogId): void
    {
        $catalogModel = new \App\Models\CatalogPesawatModel();
        $kelasModel   = new CatalogKelasModel();
        $kursiModel   = new KursiModel();

        $catalog = $catalogModel->find($catalogId);
        if (!$catalog) return;

        // Note: KAPASITAS on PESAWAT can override catalog capacity if we are generating for a specific plane
        $pesawatModel = new \App\Models\PesawatModel();
        $pesawat = $pesawatModel->find($pesawatId);
        $kapasitas = $pesawat ? (int)$pesawat['KAPASITAS'] : (int)$catalog['TOTAL_KAPASITAS'];

        $layoutStr = $catalog['LAYOUT_KURSI'] ?? '3-3';

        // Get first available class name
        $kelasList = $kelasModel->where('ID_CATALOG', $catalogId)->findAll();
        $defaultClass = !empty($kelasList) ? $kelasList[0]['NAMA_KELAS'] : 'Ekonomi';

        // Calculate seats per row from layout (e.g. "3-3" = 6, "2-4-2" = 8)
        $layoutParts = explode('-', $layoutStr);
        $seatsPerRow = array_sum($layoutParts);

        // Standardize letters based on layout if possible
        $letters = [];
        if ($layoutStr == '2-4-2') {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        } else if ($layoutStr == '2-2-2') {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        } else if ($layoutStr == '3-3') {
            $letters = ['A', 'B', 'C', 'D', 'E', 'F'];
        } else if ($layoutStr == '2-2') {
            $letters = ['A', 'B', 'C', 'D'];
        } else if ($layoutStr == '1-2-1') {
            $letters = ['A', 'D', 'G', 'K'];
        } else {
            for ($i = 0; $i < $seatsPerRow; $i++) {
                $letters[] = chr(65 + $i);
            }
        }

        $totalRows = (int)ceil($kapasitas / $seatsPerRow);
        $seatCount = 0;

        for ($row = 1; $row <= $totalRows; $row++) {
            foreach ($letters as $letter) {
                if ($seatCount >= $kapasitas) break 2;
                $noKursi = $row . $letter;
                $kursiModel->insert([
                    'ID_PESAWAT'       => $pesawatId,
                    'NO_KURSI2'        => $noKursi,
                    'KELAS_PENERBANAN' => $defaultClass,
                    'STATUS_KURSI'     => 'Tersedia',
                ]);
                $seatCount++;
            }
        }
    }

    /**
     * Regenerate seats (delete old, create new from catalog)
     */
    public function regenerateSeats(int $id)
    {
        $pesawat = $this->model->find($id);
        if (!$pesawat || empty($pesawat['ID_CATALOG'])) {
            return redirect()->to('/pesawat')->with('error', 'Pesawat tidak memiliki catalog.');
        }

        $kursiModel = new KursiModel();

        // Delete existing seats
        $kursiModel->where('ID_PESAWAT', $id)->delete();

        // Regenerate from catalog
        $this->generateSeatsFromCatalog($id, (int)$pesawat['ID_CATALOG']);

        return redirect()->to('/pesawat')->with('success', 'Kursi berhasil di-generate ulang sesuai layout dan kapasitas pesawat.');
    }
}
