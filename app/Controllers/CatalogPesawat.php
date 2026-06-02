<?php

namespace App\Controllers;

use App\Models\CatalogPesawatModel;
use App\Models\CatalogKelasModel;

class CatalogPesawat extends BaseController
{
    /** @var CatalogPesawatModel */
    protected $model;

    public function __construct()
    {
        $this->model = new CatalogPesawatModel();
    }

    public function index()
    {
        $catalogs = $this->model->findAll();
        $kelasModel = new CatalogKelasModel();

        // Attach kelas data to each catalog
        foreach ($catalogs as &$cat) {
            $cat['kelas'] = $kelasModel->where('ID_CATALOG', $cat['ID_CATALOG'])->orderBy('BARIS_MULAI', 'ASC')->findAll();
        }

        $data = [
            'title'    => 'Catalog Jenis Pesawat',
            'catalogs' => $catalogs,
        ];
        return view('catalog_pesawat/index', $data);
    }

    public function create()
    {
        $data = ['title' => 'Tambah Catalog Pesawat'];
        return view('catalog_pesawat/create', $data);
    }

    public function store()
    {
        $catalogData = [
            'TIPE_PESAWAT'    => $this->request->getPost('tipe_pesawat'),
            'KODE_TIPE'       => $this->request->getPost('kode_tipe'),
            'KATEGORI'        => $this->request->getPost('kategori'),
            'TOTAL_KAPASITAS' => 0, // Will be calculated
            'DESKRIPSI'       => $this->request->getPost('deskripsi'),
        ];

        if (!$this->model->insert($catalogData)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }

        $catalogId = $this->model->getInsertID();

        // Save class configurations
        $this->saveKelasConfig($catalogId);

        // Recalculate capacity
        $totalKapasitas = $this->model->hitungKapasitas($catalogId);
        $this->model->update($catalogId, ['TOTAL_KAPASITAS' => $totalKapasitas]);

        return redirect()->to('/catalog-pesawat')->with('success', 'Catalog pesawat berhasil ditambahkan dengan ' . $totalKapasitas . ' kursi.');
    }

    public function show(int $id)
    {
        $catalog = $this->model->getWithKelas($id);
        if (!$catalog) return redirect()->to('/catalog-pesawat')->with('error', 'Data tidak ditemukan.');

        $data = [
            'title'   => 'Detail Catalog: ' . $catalog['TIPE_PESAWAT'],
            'catalog' => $catalog,
        ];
        return view('catalog_pesawat/show', $data);
    }

    public function edit(int $id)
    {
        $catalog = $this->model->getWithKelas($id);
        if (!$catalog) return redirect()->to('/catalog-pesawat')->with('error', 'Data tidak ditemukan.');

        $data = [
            'title'   => 'Edit Catalog Pesawat',
            'catalog' => $catalog,
        ];
        return view('catalog_pesawat/edit', $data);
    }

    public function update(int $id)
    {
        $catalogData = [
            'TIPE_PESAWAT'    => $this->request->getPost('tipe_pesawat'),
            'KODE_TIPE'       => $this->request->getPost('kode_tipe'),
            'KATEGORI'        => $this->request->getPost('kategori'),
            'DESKRIPSI'       => $this->request->getPost('deskripsi'),
        ];

        if (!$this->model->update($id, $catalogData)) {
            return redirect()->back()->withInput()->with('error', implode(' ', $this->model->errors()));
        }

        // Delete old class configs and re-save
        $kelasModel = new CatalogKelasModel();
        $kelasModel->where('ID_CATALOG', $id)->delete();

        $this->saveKelasConfig($id);

        // Recalculate capacity
        $totalKapasitas = $this->model->hitungKapasitas($id);
        $this->model->update($id, ['TOTAL_KAPASITAS' => $totalKapasitas]);

        return redirect()->to('/catalog-pesawat')->with('success', 'Catalog pesawat berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        try {
            // Check if any pesawat uses this catalog
            $pesawatModel = new \App\Models\PesawatModel();
            $count = $pesawatModel->where('ID_CATALOG', $id)->countAllResults();
            if ($count > 0) {
                return redirect()->to('/catalog-pesawat')->with('error', 'Gagal menghapus! Catalog ini masih digunakan oleh ' . $count . ' pesawat.');
            }

            $this->model->delete($id);
            return redirect()->to('/catalog-pesawat')->with('success', 'Catalog pesawat berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->to('/catalog-pesawat')->with('error', 'Gagal menghapus catalog.');
        }
    }

    private function saveKelasConfig(int $catalogId): void
    {
        $kelasModel = new CatalogKelasModel();

        $namaKelas   = $this->request->getPost('nama_kelas') ?? [];
        $customNama  = $this->request->getPost('custom_nama_kelas') ?? [];
        $layoutKursi = $this->request->getPost('layout_kursi') ?? [];
        $barisMulai  = $this->request->getPost('baris_mulai') ?? [];
        $barisAkhir  = $this->request->getPost('baris_akhir') ?? [];
        $hurufKursi  = $this->request->getPost('huruf_kursi') ?? [];
        $warnaKelas  = $this->request->getPost('warna_kelas') ?? [];

        for ($i = 0; $i < count($namaKelas); $i++) {
            $name = $namaKelas[$i];
            if ($name === 'NEW') {
                $name = $customNama[$i] ?? '';
            }
            
            if (empty($name)) continue;

            $kelasModel->insert([
                'ID_CATALOG'   => $catalogId,
                'NAMA_KELAS'   => $name,
                'LAYOUT_KURSI' => $layoutKursi[$i] ?? '3-3',
                'BARIS_MULAI'  => (int)($barisMulai[$i] ?? 1),
                'BARIS_AKHIR'  => (int)($barisAkhir[$i] ?? 1),
                'HURUF_KURSI'  => strtoupper($hurufKursi[$i] ?? 'ABCDEF'),
                'WARNA_KELAS'  => $warnaKelas[$i] ?? '#3b82f6',
            ]);
        }
    }
}
