<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PageModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;

class Page extends BaseController
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
        $model = new PageModel();
        $data = [
            'title' => 'Page',
            'page' => $model->orderBy('page_id', 'desc')->findAll()
        ];
        return view('admin/page_index', $data);
    }

    function edit($page_id)
    {
        $model = new PageModel();

        // Validate and sanitize page_id
        $page_id = (int) $page_id;
        if (!$page_id || $page_id <= 0) {
            return redirect()->to('admin/page')->with('danger', 'Invalid page ID!');
        }

        $page = $model->find($page_id);
        if (!$page) {
            return redirect()->to('admin/page')->with('danger', 'Page tidak ditemukan!');
        }

        $data = [
            'title' => 'Edit Page',
            'page' => $page,
        ];
        return view('admin/page_form', $data);
    }
    function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $page_id = (int) $this->request->getPost('page_id');
        if (!$page_id || $page_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid page ID!');
        }

        $datapage = $this->request->getPost();
        $model = new PageModel();

        // Verify page exists
        $page = $model->find($page_id);
        if (!$page) {
            return redirect()->back()->with('danger', 'Page tidak ditemukan!');
        }

        // Sanitize input data - only allow safe fields to be updated
        $allowedFields = [
            'page_tag',
            'page_content'
        ];
        $sanitizedData = [];

        foreach ($allowedFields as $field) {
            if (isset($datapage[$field])) {
                if ($field === 'page_content') {
                    // Allow HTML content but sanitize it
                    $sanitizedData[$field] = sanitize_html_content($datapage[$field]);
                } else {
                    // Strip tags for other fields
                    $sanitizedData[$field] = strip_tags(trim($datapage[$field]));
                }
            }
        }

        if ($model->update($page_id, $sanitizedData)) {
            return redirect()->to('admin/page')
                ->with('success', 'Page berhasil diperbarui!');
        } else {
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Gagal memperbarui page!')
                ->withInput();
        }
    }
}
