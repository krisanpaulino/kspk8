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
        return view('admin/cerita_index', $data);
    }
    public function rejected()
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Cerita Alumni Rejected',
            'cerita' => $model->findCerita('rejected')
        ];
        return view('admin/cerita_index', $data);
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

    public function edit($cerita_id)
    {
        $model = new CeritaModel();
        $data = [
            'title' => 'Edit Cerita Alumni',
            'cerita' => $model->findSingle($cerita_id)
        ];
        return view('admin/cerita_edit', $data);
    }

    public function update()
    {
        $cerita_id = $this->request->getPost('cerita_id');
        $cerita_judul = $this->request->getPost('cerita_judul');
        $cerita_isi = $this->request->getPost('cerita_isi');
        $cerita_nama = $this->request->getPost('cerita_nama');

        $validationRules = [
            'cerita_judul' => 'required',
            'cerita_isi' => 'required',
            'cerita_nama' => 'required',
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new CeritaModel();
        $model->update($cerita_id, [
            'cerita_judul' => $cerita_judul,
            'cerita_isi' => $cerita_isi,
            'cerita_nama' => $cerita_nama,
        ]);

        return redirect()->to('admin/cerita-alumni/' . $cerita_id)
            ->with('success', 'Cerita berhasil diupdate!');
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Cerita Alumni',
            'url' => 'store'
        ];
        return view('admin/cerita_tambah', $data);
    }

    public function store()
    {
        $datacerita = $this->request->getPost();

        $datacerita['cerita_tanggal'] = date('Y-m-d H:i:s');
        $datacerita['cerita_status'] = 'pending';

        $model = new CeritaModel();
        $cerita_id = $model->insert($datacerita, true);

        if ($cerita_id == false) {
            return redirect()->back()->with('errors', $model->errors())
                ->with('error', 'Gagal menambahkan cerita! Data tidak lengkap')->withInput();
        }

        return redirect()->to('admin/cerita-alumni')
            ->with('success', 'Cerita alumni berhasil ditambahkan!');
    }
}
