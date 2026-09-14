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
            'agenda' => $agendaModel->limit(5)->find(),
            'karier' => $karierModel->limit(5)->find()
        ];
        $data = array_merge($data, $model->getCachedStats());
        return view('admin/dashboard', $data);
    }
}
