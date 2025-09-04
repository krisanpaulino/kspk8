<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Models\AlumniModel;
use App\Models\KarierModel;
use CodeIgniter\HTTP\ResponseInterface;

class Dashboard extends BaseController
{
    public function admin()
    {
        $model = new AlumniModel();
        $agendaModel = new AgendaModel();
        $karierModel = new KarierModel();
        $data = [
            'title' => 'Admin Dashboard',
            'alumni' => $model->jumlah(),
            'chart_alumni' => $model->countTahun(5),
            'tahunalumni' => $model->countTahun(),
            'agenda' => $agendaModel->limit(5)->find(),
            'karier' => $karierModel->limit(5)->find()
        ];
        return view('admin/dashboard', $data);
    }
}
