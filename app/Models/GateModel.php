<?php

namespace App\Models;

use CodeIgniter\Model;

class GateModel extends Model
{
    protected $table            = 'GATE';
    protected $primaryKey       = 'ID_GATE';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['NOMOR_GATE', 'TERMINAL'];

    protected $validationRules = [
        'NOMOR_GATE' => 'required|max_length[10]',
        'TERMINAL'   => 'required|max_length[10]',
    ];
}
