<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KarierModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Karier extends BaseController
{
    public function index()
    {
        $model = new KarierModel();
        $data = [
            'title' => 'Karier',
            'karier' => $model->findKarier()
        ];
        return view('admin/karier_index', $data);
    }
    public function detail($karier_id)
    {
        $model = new KarierModel();

        // Validate and sanitize karier_id
        $karier_id = (int) $karier_id;
        if (!$karier_id || $karier_id <= 0) {
            return redirect()->to('admin/karier')->with('danger', 'Invalid karier ID!');
        }

        $karier = $model->find($karier_id);
        if (!$karier) {
            return redirect()->to('admin/karier')->with('danger', 'Karier tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Persiapan Karier',
            'karier' => $karier
        ];
        return view('admin/karier_detail', $data);
    }

    function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $file = $this->request->getFile('karier_flyer');
        $model = new KarierModel();
        $data = $this->request->getPost();

        // Sanitize input data
        if (isset($data['karier_judul'])) {
            $data['karier_judul'] = strip_tags(trim($data['karier_judul']));
        }
        if (isset($data['karier_deskripsi'])) {
            $data['karier_deskripsi'] = strip_tags(trim($data['karier_deskripsi']));
        }

        // File validation and handling
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('danger', 'File harus berformat gambar (JPEG, PNG, GIF)!')->withInput();
            }

            // Validate file size (max 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('danger', 'File terlalu besar! Maksimal 2MB')->withInput();
            }

            try {
                $filename = $file->getRandomName();
                $path = './assets/img/karier';
                $file->move($path, $filename, true);
                $data['karier_flyer'] = $filename;
            } catch (Exception $e) {
                return redirect()->back()->with('danger', 'Gagal mengupload file!')->withInput();
            }
        }

        if ($model->insert($data)) {
            return redirect()->to('admin/karier')
                ->with('success', 'Data Karier berhasil disimpan!');
        } else {
            return redirect()->back()
                ->with('danger', 'Data Gagal Disimpan!')
                ->with('errors', $model->errors())
                ->withInput();
        }
    }

    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $data = (array)$this->request->getPost();
        $model = new KarierModel();

        // Validate karier_id
        $karier_id = (int) $data['karier_id'];
        if (!$karier_id || $karier_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid karier ID!');
        }

        $karier = $model->find($karier_id);
        if (!$karier) {
            return redirect()->back()->with('danger', 'Karier tidak ditemukan!');
        }

        // Sanitize input data
        if (isset($data['karier_judul'])) {
            $data['karier_judul'] = strip_tags(trim($data['karier_judul']));
        }
        if (isset($data['karier_deskripsi'])) {
            $data['karier_deskripsi'] = strip_tags(trim($data['karier_deskripsi']));
        }

        $file = $this->request->getFile('karier_flyer');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!in_array($file->getMimeType(), $allowedTypes)) {
                return redirect()->back()->with('danger', 'File harus berformat gambar!')->withInput();
            }

            // Validate file size (max 2MB)
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()->with('danger', 'File terlalu besar! Maksimal 2MB')->withInput();
            }

            try {
                $filename = $file->getRandomName();
                $path = './assets/img/karier';
                $file->move($path, $filename, true);
                $data['karier_flyer'] = $filename;
            } catch (Exception $e) {
                return redirect()->back()->with('danger', 'Gagal mengupload file!')->withInput();
            }
        }

        if ($model->update($karier_id, $data)) {
            return redirect()->back()->with('success', 'Data Karier Berhasil Disimpan!');
        }
        return redirect()->back()
            ->with('errors', $model->errors())
            ->with('danger', 'Data gagal disimpan!')
            ->withInput();
    }

    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $karier_id = (int) $this->request->getPost('karier_id');

        // Validate karier_id
        if (!$karier_id || $karier_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid karier ID!');
        }

        $model = new KarierModel();

        // Check if record exists
        $karier = $model->find($karier_id);
        if (!$karier) {
            return redirect()->back()->with('danger', 'Karier tidak ditemukan!');
        }

        $deleted = $model->delete($karier_id);

        if ($deleted) {
            return redirect()->back()->with('success', 'Data Karier dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data karier!');
        }
    }
}
