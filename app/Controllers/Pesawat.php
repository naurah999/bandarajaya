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
            $data['KAPASITAS'] = $catalog['TOTAL_KAPASITAS'];
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
            $data['KAPASITAS'] = $catalog['TOTAL_KAPASITAS'];
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
     * Generate seats from catalog class configuration
     */
    private function generateSeatsFromCatalog(int $pesawatId, int $catalogId): void
    {
        $kelasModel = new CatalogKelasModel();
        $kursiModel = new KursiModel();

        $kelasList = $kelasModel->where('ID_CATALOG', $catalogId)->orderBy('BARIS_MULAI', 'ASC')->findAll();

        foreach ($kelasList as $kelas) {
            $hurufList = str_split($kelas['HURUF_KURSI']);

            for ($row = $kelas['BARIS_MULAI']; $row <= $kelas['BARIS_AKHIR']; $row++) {
                foreach ($hurufList as $huruf) {
                    $noKursi = $row . $huruf;
                    $kursiModel->insert([
                        'ID_PESAWAT'       => $pesawatId,
                        'NO_KURSI2'        => $noKursi,
                        'KELAS_PENERBANAN' => $kelas['NAMA_KELAS'],
                        'STATUS_KURSI'     => 'Tersedia',
                    ]);
                }
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

        return redirect()->to('/pesawat')->with('success', 'Kursi berhasil di-generate ulang sesuai catalog.');
    }
}
