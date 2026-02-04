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

        // Validate and sanitize cerita_id
        $cerita_id = (int) $cerita_id;
        if (!$cerita_id || $cerita_id <= 0) {
            return redirect()->to('admin/cerita-alumni')->with('danger', 'Invalid cerita ID!');
        }

        $cerita = $model->findSingle($cerita_id);
        if (!$cerita) {
            return redirect()->to('admin/cerita-alumni')->with('danger', 'Cerita tidak ditemukan!');
        }

        $data = [
            'title' => 'Cerita Alumni',
            'cerita' => $cerita
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
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $cerita_id = (int) $this->request->getPost('cerita_id');

        // Validate cerita_id
        if (!$cerita_id || $cerita_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid cerita ID!');
        }

        $model = new CeritaModel();

        // Check if record exists
        $cerita = $model->find($cerita_id);
        if (!$cerita) {
            return redirect()->back()->with('danger', 'Cerita tidak ditemukan!');
        }

        if ($model->update($cerita_id, ['cerita_status' => 'approved'])) {
            log_security_event('Cerita approved', [
                'cerita_id' => $cerita_id,
                'admin' => session('user')->user_email ?? 'unknown'
            ]);
            return redirect()->to('admin/cerita-alumni')
                ->with('success', 'Cerita berhasil diapprove!');
        }
        return redirect()->back()
            ->with('danger', 'Gagal mengapprove cerita!');
    }

    public function reject()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $cerita_id = (int) $this->request->getPost('cerita_id');

        // Validate cerita_id
        if (!$cerita_id || $cerita_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid cerita ID!');
        }

        $model = new CeritaModel();

        // Check if record exists
        $cerita = $model->find($cerita_id);
        if (!$cerita) {
            return redirect()->back()->with('danger', 'Cerita tidak ditemukan!');
        }

        if ($model->update($cerita_id, ['cerita_status' => 'rejected'])) {
            log_security_event('Cerita rejected', [
                'cerita_id' => $cerita_id,
                'admin' => session('user')->user_email ?? 'unknown'
            ]);
            return redirect()->to('admin/cerita-alumni')
                ->with('success', 'Cerita berhasil ditolak!');
        }
        return redirect()->back()
            ->with('danger', 'Gagal menolak cerita!');
    }

    public function edit($cerita_id)
    {
        $model = new CeritaModel();

        // Validate and sanitize cerita_id
        $cerita_id = (int) $cerita_id;
        if (!$cerita_id || $cerita_id <= 0) {
            return redirect()->to('admin/cerita-alumni')->with('danger', 'Invalid cerita ID!');
        }

        $cerita = $model->findSingle($cerita_id);
        if (!$cerita) {
            return redirect()->to('admin/cerita-alumni')->with('danger', 'Cerita tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Cerita Alumni',
            'cerita' => $cerita
        ];
        return view('admin/cerita_edit', $data);
    }

    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $cerita_id = (int) $this->request->getPost('cerita_id');
        $cerita_judul = strip_tags(trim($this->request->getPost('cerita_judul')));
        $cerita_isi = sanitize_html_content($this->request->getPost('cerita_isi'));
        $cerita_nama = strip_tags(trim($this->request->getPost('cerita_nama')));

        // Validate cerita_id
        if (!$cerita_id || $cerita_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid cerita ID!');
        }

        $validationRules = [
            'cerita_judul' => 'required|min_length[5]|max_length[200]',
            'cerita_isi' => 'required|min_length[10]',
            'cerita_nama' => 'required|min_length[2]|max_length[100]|alpha_space',
        ];

        $validationData = [
            'cerita_judul' => $cerita_judul,
            'cerita_isi' => $cerita_isi,
            'cerita_nama' => $cerita_nama
        ];

        if (!$this->validate($validationRules)) {
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        $model = new CeritaModel();

        // Check if record exists
        $cerita = $model->find($cerita_id);
        if (!$cerita) {
            return redirect()->back()->with('danger', 'Cerita tidak ditemukan!');
        }

        if ($model->update($cerita_id, [
            'cerita_judul' => $cerita_judul,
            'cerita_isi' => $cerita_isi,
            'cerita_nama' => $cerita_nama,
        ])) {
            return redirect()->to('admin/cerita-alumni/' . $cerita_id)
                ->with('success', 'Cerita berhasil diupdate!');
        }

        return redirect()->back()
            ->with('errors', $model->errors())
            ->with('danger', 'Gagal mengupdate cerita!')
            ->withInput();
    }

    /**
     * Sanitize HTML content for cerita
     */
    private function sanitizeHtmlContent($html)
    {
        // Define allowed tags for cerita content
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><div><span>';

        // Strip dangerous tags first
        $html = strip_tags($html, $allowedTags);

        // Remove potentially dangerous attributes and javascript
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/on\w+\s*=/i', '', $html);
        $html = preg_replace('/style\s*=/i', '', $html);
        $html = preg_replace('/data-\w+\s*=/i', '', $html);

        // Additional XSS prevention
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        $html = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi', '', $html);

        return $html;
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
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $datacerita = $this->request->getPost();

        // Sanitize input data
        if (isset($datacerita['cerita_judul'])) {
            $datacerita['cerita_judul'] = strip_tags(trim($datacerita['cerita_judul']));
        }
        if (isset($datacerita['cerita_nama'])) {
            $datacerita['cerita_nama'] = strip_tags(trim($datacerita['cerita_nama']));
        }
        if (isset($datacerita['cerita_isi'])) {
            $datacerita['cerita_isi'] = sanitize_html_content($datacerita['cerita_isi']);
        }

        $datacerita['cerita_tanggal'] = date('Y-m-d H:i:s');
        $datacerita['cerita_status'] = 'pending';

        $model = new CeritaModel();
        $cerita_id = $model->insert($datacerita, true);

        if ($cerita_id == false) {
            return redirect()->back()->with('errors', $model->errors())
                ->with('danger', 'Gagal menambahkan cerita! Data tidak lengkap')->withInput();
        }

        return redirect()->to('admin/cerita-alumni')
            ->with('success', 'Cerita alumni berhasil ditambahkan!');
    }
}
