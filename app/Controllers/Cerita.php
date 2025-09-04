<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CeritaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Cerita extends BaseController
{
    public function index()
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Cerita Alumni',
            'cerita' => $model->findCerita('pending')
        ];
        return view('admin/cerita_index', $data);
    }
    public function detail($cerita_id)
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Cerita Alumni',
            'cerita' => $model->findSingle($cerita_id)
        ];
        return view('admin/cerita_detail', $data);
    }
    public function approved()
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Cerita Alumni Approved',
            'cerita' => $model->findCerita('approved')
        ];
        return view('admin/cerita_status', $data);
    }
    public function rejected()
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Cerita Alumni Rejected',
            'cerita' => $model->findCerita('rejected')
        ];
        return view('admin/cerita_status', $data);
    }
    public function approve()
    {
        $cerita_id = $this->request->getPost('cerita_id');
        $model = new CeritaModel();

        if ($model->update($cerita_id, ['cerita_status' => 'approved'])) {
            return redirect()->to('admin/cerita-alumni')
                ->with('success', 'Cerita berhasil diapprove!!');
        }
        return redirect()->back()
            ->with('success', 'Cerita berhasil diapprove!!');
    }
    public function reject()
    {
        $cerita_id = $this->request->getPost('cerita_id');
        $model = new CeritaModel();

        if ($model->update($cerita_id, ['cerita_status' => 'rejected'])) {
            return redirect()->to('admin/cerita-alumni')
                ->with('success', 'Cerita berhasil ditolak!!');
        }
        return redirect()->back()
            ->with('success', 'Cerita berhasil diapprove!!');
    }
}
