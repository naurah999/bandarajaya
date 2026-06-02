<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogPesawatModel extends Model
{
    protected $table            = 'CATALOG_PESAWAT';
    protected $primaryKey       = 'ID_CATALOG';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['TIPE_PESAWAT', 'KODE_TIPE', 'KATEGORI', 'LAYOUT_KURSI', 'TOTAL_KAPASITAS', 'DESKRIPSI'];

    protected $validationRules = [
        'TIPE_PESAWAT'    => 'required|max_length[50]',
        'KODE_TIPE'       => 'required|max_length[20]',
        'KATEGORI'        => 'required|max_length[20]',
        'LAYOUT_KURSI'    => 'required|max_length[10]',
        'TOTAL_KAPASITAS' => 'required|numeric',
    ];

    /**
     * Get catalog with class configurations
     */
    public function getWithKelas(int $id = null)
    {
        if ($id) {
            $catalog = $this->find($id);
            if ($catalog) {
                $kelasModel = new CatalogKelasModel();
                $catalog['kelas'] = $kelasModel->where('ID_CATALOG', $id)->findAll();
            }
            return $catalog;
        }

        return $this->orderBy('TIPE_PESAWAT', 'ASC')->findAll();
    }
}
