<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;
use Exception;

class Kerjasama extends BaseController
{
    /**
     * Sanitize HTML content to prevent XSS while allowing safe HTML tags
     */
    private function sanitizeHtmlContent($content)
    {
        // Define allowed HTML tags and attributes
        $allowed_tags = [
            'p' => ['class', 'style'],
            'br' => [],
            'strong' => ['class'],
            'b' => ['class'],
            'em' => ['class'],
            'i' => ['class'],
            'u' => ['class'],
            'h1' => ['class', 'style'],
            'h2' => ['class', 'style'],
            'h3' => ['class', 'style'],
            'h4' => ['class', 'style'],
            'ul' => ['class'],
            'ol' => ['class'],
            'li' => ['class'],
            'img' => ['src', 'alt', 'width', 'height', 'class', 'style'],
            'a' => ['href', 'title', 'class'],
            'div' => ['class', 'style'],
            'span' => ['class', 'style'],
        ];

        $allowed_protocols = ['http', 'https', 'data'];

        $dom = new \DOMDocument();
        $dom->encoding = 'UTF-8';

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);
        @$dom->loadHTML('<?xml encoding="UTF-8">' . $content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new \DOMXPath($dom);

        // Remove script tags and their content
        foreach ($xpath->query('//script') as $script) {
            $script->parentNode->removeChild($script);
        }

        // Remove dangerous attributes like onclick, onload, etc.
        $dangerous_attrs = ['onclick', 'onload', 'onerror', 'onmouseover', 'onfocus', 'onblur', 'onchange', 'onsubmit'];
        foreach ($dangerous_attrs as $attr) {
            foreach ($xpath->query("//@$attr") as $element) {
                $element->parentNode->removeAttribute($attr);
            }
        }

        return $dom->saveHTML();
    }

    public function index()
    {
        $model = new KerjasamaModel();
        $data = [
            'title' => 'Kerjasama',
            'kerjasama' => $model->findKerjasama()
        ];
        return view('admin/kerjasama_index', $data);
    }
    public function tambah()
    {
        $kerjasama = new KerjasamaModel();
        $data = [
            'title' => 'Tambah Kerjasama',
            'url' => 'insert',
            'kerjasama' => $kerjasama
        ];
        return view('admin/kerjasama_form', $data);
    }
    public function edit($kerjasama_id)
    {
        $model = new KerjasamaModel();

        // Validate and sanitize kerjasama_id
        $kerjasama_id = (int) $kerjasama_id;
        if (!$kerjasama_id || $kerjasama_id <= 0) {
            return redirect()->to('admin/kerjasama')->with('danger', 'Invalid kerjasama ID!');
        }

        $kerjasama = $model->find($kerjasama_id);
        if (!$kerjasama) {
            return redirect()->to('admin/kerjasama')->with('danger', 'Kerjasama tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail',
            'url' => 'update',
            'kerjasama' => $kerjasama,
        ];
        return view('admin/kerjasama_form', $data);
    }
    function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $model = new KerjasamaModel();
        $data = $this->request->getPost();

        // Sanitize input data
        if (isset($data['kerjasama_judul'])) {
            $data['kerjasama_judul'] = strip_tags(trim($data['kerjasama_judul']));
        }

        if (isset($data['kerjasama_isi'])) {
            $data['kerjasama_isi'] = sanitize_html_content($data['kerjasama_isi']);
        }

        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['kerjasama_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');

            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || strpos($url, 'data:image/') === 0) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    // Sanitize filename to prevent directory traversal
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $data['kerjasama_gambar'] = $image;
                }
            }

            if ($model->insert($data)) {
                return redirect()->to('admin/kerjasama')
                    ->with('success', 'Data kerjsama berhasil disimpan!!');
            }
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Periksa kembali data kerjsama!')
                ->withInput();
        } else {
            return redirect()->back()
                ->with('danger', 'Detail kerjasama harus ada gambar!')
                ->withInput();
        }
    }
    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $kerjasama_id = (int) $this->request->getPost('kerjasama_id');
        if (!$kerjasama_id || $kerjasama_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid kerjasama ID!');
        }

        $data = $this->request->getPost();
        $model = new KerjasamaModel();

        // Sanitize input data
        if (isset($data['kerjasama_judul'])) {
            $data['kerjasama_judul'] = strip_tags(trim($data['kerjasama_judul']));
        }

        if (isset($data['kerjasama_isi'])) {
            $data['kerjasama_isi'] = sanitize_html_content($data['kerjasama_isi']);
        }

        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['kerjasama_isi'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');

            // Validate and sanitize image URL
            if (filter_var($url, FILTER_VALIDATE_URL) || strpos($url, 'data:image/') === 0) {
                $pathinfo = pathinfo($url);
                if (isset($pathinfo['filename']) && isset($pathinfo['extension'])) {
                    // Sanitize filename to prevent directory traversal
                    $image = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $pathinfo['filename'] . '.' . $pathinfo['extension']);
                    $data['kerjasama_gambar'] = $image;
                }
            }

            if ($model->update($kerjasama_id, $data)) {
                return redirect()->back()
                    ->with('success', 'Data kerjasama berhasil disimpan!!');
            } else {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->with('danger', 'Periksa kembali data kerjasama!')
                    ->withInput();
            }
            // dd($image);
        } else {
            return redirect()->back()
                ->with('danger', 'Detail kerjasama harus ada gambar!')
                ->withInput();
        }
    }
    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $kerjasama_id = (int) $this->request->getPost('kerjasama_id');
        if (!$kerjasama_id || $kerjasama_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid kerjasama ID!');
        }

        $model = new KerjasamaModel();

        // Verify record exists before deletion
        $kerjasama = $model->find($kerjasama_id);
        if (!$kerjasama) {
            return redirect()->back()->with('danger', 'Data kerjasama tidak ditemukan!');
        }

        if ($model->delete($kerjasama_id)) {
            return redirect()->back()->with('success', 'Data kerjasama berhasil dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data kerjasama!');
        }
    }
}
