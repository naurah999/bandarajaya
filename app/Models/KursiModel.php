<?php

namespace App\Models;

use CodeIgniter\Model;

class KursiModel extends Model
{
    protected $table            = 'KURSI';
    protected $primaryKey       = 'ID_KURSI';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['ID_PESAWAT', 'NO_KURSI2', 'KELAS_PENERBANAN'];

    protected $validationRules = [
        'ID_PESAWAT'       => 'required|numeric',
        'NO_KURSI2'        => 'required|max_length[10]',
        'KELAS_PENERBANAN' => 'required|max_length[50]',
    ];

    public function getWithPesawat()
    {
        return $this->select('KURSI.*, PESAWAT.KODE_PESAWAT, PESAWAT.TIPE_PESAWAT, MASKAPAI.NAMA_MASKAPAI')
                    ->join('PESAWAT', 'PESAWAT.ID_PESAWAT = KURSI.ID_PESAWAT', 'left')
                    ->join('MASKAPAI', 'MASKAPAI.ID_MASKAPAI = PESAWAT.ID_MASKAPAI', 'left')
                    ->findAll();
    }

    public function getAvailableSeats(int $idPesawat, int $idPenerbangan)
    {
        // Get occupied seats for this flight
        $occupied = $this->db->table('CHECKIN')
            ->select('ID_KURSI')
            ->join('TIKET', 'TIKET.ID_TIKET = CHECKIN.ID_TIKET')
            ->where('TIKET.ID_PENERBANGAN', $idPenerbangan)
            ->get()
            ->getResultArray();
            
        $occupiedIds = array_column($occupied, 'ID_KURSI');

        $builder = $this->where('ID_PESAWAT', $idPesawat);
        if (!empty($occupiedIds)) {
            $builder->whereNotIn('ID_KURSI', $occupiedIds);
        }
        
        return $builder->findAll();
    }
}
