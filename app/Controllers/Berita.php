<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;

class Berita extends BaseController
{
    /**
     * Sanitize HTML content to prevent XSS attacks
     * Allow only safe HTML tags and attributes
     */
    private function sanitizeHtmlContent($html)
    {
        // Define allowed tags and attributes
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><img><table><tr><td><th><thead><tbody>';

        // Strip dangerous tags first
        $html = strip_tags($html, $allowedTags);

        // Remove potentially dangerous attributes and javascript
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/on\w+\s*=/i', '', $html); // Remove onload, onclick, etc.
        $html = preg_replace('/style\s*=/i', '', $html); // Remove style attributes

        return $html;
    }

    public function index()
    {
        $model = new BeritaModel();
        $data = [
            'title' => 'Daftar Berita',
            'berita' => $model->orderBy('berita_id', 'desc')->findAll()
        ];
        return view('admin/berita_index', $data);
    }
    function tambah()
    {
        $berita = new BeritaModel();
        $data = [
            'title' => 'Tambah Berita',
            'berita' => $berita,
            'url' => 'insert'
        ];
        return view('admin/berita_form', $data);
    }
    function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        // Get and validate POST data
        $databerita = $this->request->getPost();

        // Additional input sanitization
        if (isset($databerita['berita_judul'])) {
            $databerita['berita_judul'] = strip_tags(trim($databerita['berita_judul']));
        }

        // Sanitize HTML content while preserving safe tags
        if (isset($databerita['berita_isi'])) {
            $databerita['berita_isi'] = $this->sanitizeHtmlContent($databerita['berita_isi']);
        }

        //Insert data to Berita
        //find images
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Use libxml to handle HTML5 properly and suppress warnings
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $databerita['berita_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || filter_var($url, FILTER_SANITIZE_URL)) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $databerita['berita_thumbnail'] = $image;
                }
            }
        }
        // dd($image);

        $databerita['berita_tanggal'] = date('Y-m-d');
        $model = new BeritaModel();
        $berita_id = $model->insert($databerita, true);
        if ($berita_id == false) {
            // dd($model->errors());
            return redirect()->back()->with('errors', $model->errors())
                ->with('message', "Toastify({'text':'Gagal menambahkan sekolah! Data tidak lengkap', style: {
            background: '#fd2e64',
          }}).showToast()")->withInput();
        }

        // //File Upload 
        // $filename = 'berita' . $berita_id . '.' . $file->getClientExtension();
        // $file->move('assets/img/berita', $filename, true);

        // //Updating data in berita
        // $data['berita_foto'] = $filename;
        // $model->update($berita_id, $data);


        //done
        return redirect()->to('admin/berita')
            ->with('message', "Toastify({'text':'berita ditambahkan!'}).showToast()");
    }

    function edit($berita_id)
    {
        $model = new BeritaModel();

        $data = [
            'title' => 'Edit Berita',
            'berita' => $model->find($berita_id),
            'url' => 'update'
        ];
        return view('admin/berita_form', $data);
    }
    function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        // Get and validate POST data
        $berita_id = (int) $this->request->getPost('berita_id');
        $databerita = $this->request->getPost();

        // Validate berita_id
        if (!$berita_id || $berita_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid berita ID!');
        }

        // Additional input sanitization
        if (isset($databerita['berita_judul'])) {
            $databerita['berita_judul'] = strip_tags(trim($databerita['berita_judul']));
        }

        // Sanitize HTML content while preserving safe tags
        if (isset($databerita['berita_isi'])) {
            $databerita['berita_isi'] = $this->sanitizeHtmlContent($databerita['berita_isi']);
        }

        //Update data to Berita
        //find images
        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Use libxml to handle HTML5 properly and suppress warnings
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $databerita['berita_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || filter_var($url, FILTER_SANITIZE_URL)) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $databerita['berita_thumbnail'] = $image;
                }
            }
        }
        // dd($image);
        // $databerita['berita_tanggal'] = date('Y-m-d');
        $model = new BeritaModel();
        $berita_id = $model->update($berita_id, $databerita);
        if ($berita_id == false) {
            // dd($model->errors());
            return redirect()->back()->with('errors', $model->errors())
                ->with('message', "Toastify({'text':'Gagal update sekolah! Data tidak lengkap', style: {
            background: '#fd2e64',
          }}).showToast()")->withInput();
        }

        // //File Upload 
        // $filename = 'berita' . $berita_id . '.' . $file->getClientExtension();
        // $file->move('assets/img/berita', $filename, true);

        // //Updating data in berita
        // $data['berita_foto'] = $filename;
        // $model->update($berita_id, $data);


        //done
        return redirect()->to('admin/berita')
            ->with('message', "Toastify({'text':'berita diupdate!'}).showToast()");
    }
    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $berita_id = (int) $this->request->getPost('berita_id');

        // Validate berita_id
        if (!$berita_id || $berita_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid berita ID!');
        }

        $model = new BeritaModel();

        // Check if record exists before deleting
        $berita = $model->find($berita_id);
        if (!$berita) {
            return redirect()->back()->with('danger', 'Berita tidak ditemukan!');
        }

        // Use the model's delete method with ID parameter for better security
        $deleted = $model->delete($berita_id);

        if ($deleted) {
            return redirect()->back()
                ->with('message', "Toastify({'text':'Berita dihapus!'}).showToast()");
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus berita!');
        }
    }
}
