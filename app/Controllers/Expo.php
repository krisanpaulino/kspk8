<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ExpoModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;
use Exception;

class Expo extends BaseController
{
    public function index()
    {
        $model = new ExpoModel();
        $data = [
            'title' => 'Expo',
            'expo' => $model->findexpo()
        ];
        return view('admin/expo_index', $data);
    }
    public function tambah()
    {
        $expo = new ExpoModel();
        $data = [
            'title' => 'Tambah Expo',
            'url' => 'insert',
            'expo' => $expo
        ];
        return view('admin/expo_form', $data);
    }
    public function edit($expo_id)
    {
        $model = new ExpoModel();

        // Validate and sanitize expo_id
        $expo_id = (int) $expo_id;
        if (!$expo_id || $expo_id <= 0) {
            return redirect()->to('admin/expo')->with('danger', 'Invalid expo ID!');
        }

        $data = [
            'title' => 'Detail',
            'url' => 'update',
            'expo' => $model->find($expo_id),
        ];

        if (!$data['expo']) {
            return redirect()->to('admin/expo')->with('danger', 'Expo tidak ditemukan!');
        }

        return view('admin/expo_form', $data);
    }

    function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $model = new ExpoModel();
        $data = $this->request->getPost();

        // Sanitize input data
        if (isset($data['expo_judul'])) {
            $data['expo_judul'] = strip_tags(trim($data['expo_judul']));
        }

        if (isset($data['expo_isi'])) {
            $data['expo_isi'] = $this->sanitizeHtmlContent($data['expo_isi']);
        }

        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['expo_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');

            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || filter_var($url, FILTER_SANITIZE_URL)) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $data['expo_gambar'] = $image;
                }
            }

            if ($model->insert($data)) {
                return redirect()->to('admin/expo')
                    ->with('success', 'Data expo berhasil disimpan!');
            }
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Periksa kembali data expo!')
                ->withInput();
        } else {
            return redirect()->back()
                ->with('danger', 'Isi expo harus ada gambar flyer!')
                ->withInput();
        }
    }

    /**
     * Sanitize HTML content for expo content
     */
    private function sanitizeHtmlContent($html)
    {
        // Define allowed tags for expo content
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><table><tr><td><th><thead><tbody><div><span>';

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
    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $expo_id = (int) $this->request->getPost('expo_id');
        $data = $this->request->getPost();

        // Validate expo_id
        if (!$expo_id || $expo_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid expo ID!');
        }

        // Sanitize input data
        if (isset($data['expo_judul'])) {
            $data['expo_judul'] = strip_tags(trim($data['expo_judul']));
        }

        if (isset($data['expo_isi'])) {
            $data['expo_isi'] = $this->sanitizeHtmlContent($data['expo_isi']);
        }

        $model = new ExpoModel();
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['expo_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');

            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || filter_var($url, FILTER_SANITIZE_URL)) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $data['expo_gambar'] = $image;
                }
            }

            if ($model->update($expo_id, $data)) {
                return redirect()->back()
                    ->with('success', 'Data expo berhasil diupdate!');
            } else {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->with('danger', 'Periksa kembali data expo!')
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->with('danger', 'Detail expo harus ada gambar!')
                ->withInput();
        }
    }

    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $expo_id = (int) $this->request->getPost('expo_id');

        // Validate expo_id
        if (!$expo_id || $expo_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid expo ID!');
        }

        $model = new ExpoModel();

        // Check if record exists before deleting
        $expo = $model->find($expo_id);
        if (!$expo) {
            return redirect()->back()->with('danger', 'Expo tidak ditemukan!');
        }

        // Use the model's delete method with ID parameter for better security
        $deleted = $model->delete($expo_id);

        if ($deleted) {
            return redirect()->back()->with('success', 'Data expo dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data expo!');
        }
    }
}
