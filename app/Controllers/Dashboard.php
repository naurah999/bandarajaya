<?php

namespace App\Controllers;

use App\Models\MaskapaiModel;
use App\Models\PesawatModel;
use App\Models\GateModel;
use App\Models\PenerbanganModel;
use App\Models\PenumpangModel;
use App\Models\TiketModel;
use App\Models\CheckinModel;
use App\Models\BoardingPassModel;

class Dashboard extends BaseController
{
    public function index()
    {
        /** @var MaskapaiModel $maskapaiModel */
        $maskapaiModel     = new MaskapaiModel();
        /** @var PesawatModel $pesawatModel */
        $pesawatModel      = new PesawatModel();
        /** @var GateModel $gateModel */
        $gateModel         = new GateModel();
        /** @var PenerbanganModel $penerbanganModel */
        $penerbanganModel  = new PenerbanganModel();
        /** @var PenumpangModel $penumpangModel */
        $penumpangModel    = new PenumpangModel();
        /** @var TiketModel $tiketModel */
        $tiketModel        = new TiketModel();
        /** @var CheckinModel $checkinModel */
        $checkinModel      = new CheckinModel();
        /** @var BoardingPassModel $boardingPassModel */
        $boardingPassModel = new BoardingPassModel();

        $data = [
            'title'              => 'Dashboard',
            'total_maskapai'     => $maskapaiModel->countAll(),
            'total_pesawat'      => $pesawatModel->countAll(),
            'total_gate'         => $gateModel->countAll(),
            'total_penerbangan'  => $penerbanganModel->countAll(),
            'total_penumpang'    => $penumpangModel->countAll(),
            'total_tiket'        => $tiketModel->countAll(),
            'total_checkin'      => $checkinModel->countAll(),
            'total_boarding'     => $boardingPassModel->countAll(),
            'penerbangan_terbaru'=> $penerbanganModel->getWithRelations(),
        ];

    }

    }
}
