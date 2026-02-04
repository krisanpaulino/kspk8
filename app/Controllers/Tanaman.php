<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TanamanModel;
use DOMDocument;

class Tanaman extends BaseController
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
        $model = new TanamanModel();
        if (session('user')->user_type == 'petani')
            $tanaman = $model->byPetani(petani()->petani_id);
        else
            $tanaman = $model->getAll();
        $data = [
            'title' => 'Data Tanaman',
            'tanaman' => $tanaman
        ];
        return view('Tanaman/index', $data);
    }
    public function tambah()
    {
        $tanamanModel = new TanamanModel();
        $data['title'] = 'Tambah Tanaman';
        $data['form_title'] = 'Tambah Tanaman';
        $data['tanaman'] = $tanamanModel;
        return view('Tanaman/form', $data);
    }
    public function store()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $data = $this->request->getPost();
        $model = new TanamanModel();

        // Sanitize input data
        if (isset($data['tanaman_judul'])) {
            $data['tanaman_judul'] = strip_tags(trim($data['tanaman_judul']));
        }

        if (isset($data['tanaman_detail'])) {
            $data['tanaman_detail'] = sanitize_html_content($data['tanaman_detail']);
        }

        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['tanaman_detail'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                    $data['tanaman_gambar'] = $image;
                }
            }

            if ($model->insert($data)) {
                return redirect()->to(session('user')->user_type . '/tanaman')
                    ->with('success', 'Data tanaman berhasil disimpan!');
            }
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Periksa kembali data tanaman!')
                ->withInput();
        } else {
            return redirect()->back()
                ->with('danger', 'Detail tanaman harus ada gambar!')
                ->withInput();
        }
    }
    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $tanaman_id = (int) $this->request->getPost('tanaman_id');
        if (!$tanaman_id || $tanaman_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid tanaman ID!');
        }

        $data = $this->request->getPost();
        $model = new TanamanModel();

        // Sanitize input data
        if (isset($data['tanaman_judul'])) {
            $data['tanaman_judul'] = strip_tags(trim($data['tanaman_judul']));
        }

        if (isset($data['tanaman_detail'])) {
            $data['tanaman_detail'] = sanitize_html_content($data['tanaman_detail']);
        }

        $doc = new DOMDocument();
        $doc->encoding = 'UTF-8';

        // Suppress warnings for invalid HTML
        libxml_use_internal_errors(true);
        @$doc->loadHTML('<?xml encoding="UTF-8">' . $data['tanaman_detail'], LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
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
                    $data['tanaman_gambar'] = $image;
                }
            }

            if ($model->update($tanaman_id, $data)) {
                return redirect()->back()
                    ->with('success', 'Data tanaman berhasil disimpan!');
            } else {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->with('danger', 'Periksa kembali data tanaman!')
                    ->withInput();
            }
        } else {
            return redirect()->back()
                ->with('danger', 'Detail tanaman harus ada gambar!')
                ->withInput();
        }
    }
    public function edit($tanaman_id)
    {
        $model = new TanamanModel();

        // Validate and sanitize tanaman_id
        $tanaman_id = (int) $tanaman_id;
        if (!$tanaman_id || $tanaman_id <= 0) {
            return redirect()->to('admin/tanaman')->with('danger', 'Invalid tanaman ID!');
        }

        $tanaman = $model->find($tanaman_id);
        if (!$tanaman) {
            return redirect()->to('admin/tanaman')->with('danger', 'Tanaman tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Tanaman',
            'tanaman' => $tanaman
        ];
        $data['form_title'] = 'Update Tanaman';

        return view('Tanaman/form', $data);
    }
    public function detail($tanaman_id)
    {
        $model = new TanamanModel();

        // Validate and sanitize tanaman_id
        $tanaman_id = (int) $tanaman_id;
        if (!$tanaman_id || $tanaman_id <= 0) {
            return redirect()->to('admin/tanaman')->with('danger', 'Invalid tanaman ID!');
        }

        $tanaman = $model->getSingle($tanaman_id);
        if (!$tanaman) {
            return redirect()->to('admin/tanaman')->with('danger', 'Tanaman tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Tanaman',
            'tanaman' => $tanaman
        ];

        return view('Tanaman/detail', $data);
    }
    public function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $tanaman_id = (int) $this->request->getPost('tanaman_id');
        if (!$tanaman_id || $tanaman_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid tanaman ID!');
        }

        $model = new TanamanModel();

        // Verify record exists before deletion
        $tanaman = $model->find($tanaman_id);
        if (!$tanaman) {
            return redirect()->back()->with('danger', 'Data tanaman tidak ditemukan!');
        }

        if ($model->delete($tanaman_id)) {
            return redirect()->back()->with('success', 'Data tanaman berhasil dihapus');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data tanaman!');
        }
    }
    public function detailFront($tanaman_id)
    {
        $model = new TanamanModel();

        // Validate and sanitize tanaman_id
        $tanaman_id = (int) $tanaman_id;
        if (!$tanaman_id || $tanaman_id <= 0) {
            return redirect()->to('/')->with('danger', 'Invalid tanaman ID!');
        }

        $tanaman = $model->find($tanaman_id);
        if (!$tanaman) {
            return redirect()->to('/')->with('danger', 'Tanaman tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail Tanaman',
            'tanaman' => $tanaman,
        ];

        return view('Tanaman_detail', $data);
    }
}
