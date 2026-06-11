<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ArtikelModel;
use App\Models\ArtikelTagModel;
use App\Models\TagArtikelModel;

class Artikel extends BaseController
{
    private function sanitizeHtmlContent($html)
    {
        $allowedTags = '<p><br><strong><b><em><i><u><h1><h2><h3><h4><h5><h6><ul><ol><li><a><div><span><img>';
        $html = strip_tags($html, $allowedTags);
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/on\w+\s*=/i', '', $html);
        $html = preg_replace('/style\s*=/i', '', $html);
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);
        $html = preg_replace('/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi', '', $html);
        return $html;
    }

    private function makeUniqueSlug(string $slug, int $excludeId = null): string
    {
        $baseSlug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($slug)), '-');
        if ($baseSlug === '') {
            $baseSlug = 'artikel';
        }

        $model = new ArtikelModel();
        $candidate = $baseSlug;
        $counter = 1;

        while (true) {
            $builder = $model->where('slug', $candidate);
            if ($excludeId !== null) {
                $builder->where('id !=', $excludeId);
            }
            if ($builder->countAllResults() === 0) {
                return $candidate;
            }
            $candidate = $baseSlug . '-' . $counter++;
        }
    }

    private function makeUniqueTagSlug(string $name): string
    {
        $baseSlug = trim(preg_replace('/[^a-z0-9]+/', '-', strtolower($name)), '-');
        if ($baseSlug === '') {
            $baseSlug = 'tag';
        }

        $model = new TagArtikelModel();
        $candidate = $baseSlug;
        $counter = 1;
        while ($model->where('slug', $candidate)->countAllResults() > 0) {
            $candidate = $baseSlug . '-' . $counter++;
        }

        return $candidate;
    }

    private function getAllTags(): array
    {
        return (new TagArtikelModel())->orderBy('nama', 'asc')->findAll();
    }

    private function getSelectedTagIds(int $artikelId): array
    {
        return (new ArtikelTagModel())->getTagIdsByArtikel($artikelId);
    }

    private function saveArticleTags(int $artikelId, array $tagIds)
    {
        (new ArtikelTagModel())->saveTags($artikelId, $tagIds);
    }

    public function index()
    {
        $model = new ArtikelModel();
        $data = [
            'title' => 'Daftar Artikel',
            'artikel' => $model->orderBy('created_at', 'desc')->findAll(),
        ];

        return view('admin/artikel_index', $data);
    }

    public function detail($id)
    {
        $model = new ArtikelModel();
        $id = (int) $id;
        if (!$id || $id <= 0) {
            return redirect()->to('admin/artikel')->with('danger', 'Invalid artikel ID!');
        }

        $artikel = $model->find($id);
        if (!$artikel) {
            return redirect()->to('admin/artikel')->with('danger', 'Artikel tidak ditemukan!');
        }

        return view('admin/artikel_detail', [
            'title' => 'Detail Artikel',
            'artikel' => $artikel,
        ]);
    }

    public function tambah()
    {
        $data = [
            'title' => 'Tambah Artikel',
            'artikel' => new ArtikelModel(),
            'url' => 'insert',
            'tags' => $this->getAllTags(),
            'selectedTags' => [],
        ];
        return view('admin/artikel_form', $data);
    }

    public function insert()
    {
        $judul = strip_tags(trim($this->request->getPost('judul')));
        $isi = $this->sanitizeHtmlContent($this->request->getPost('isi'));
        $status = $this->request->getPost('status') === 'published' ? 'published' : 'draft';
        $published_at = $this->request->getPost('published_at');

        if ($published_at === '' || $published_at === null) {
            $published_at = null;
        } else {
            // Convert HTML5 datetime-local (YYYY-MM-DDTHH:MM) to DB timestamp (YYYY-MM-DD HH:MM:SS)
            if (strpos($published_at, 'T') !== false) {
                $dt = \DateTime::createFromFormat('Y-m-d\\TH:i', $published_at);
                if ($dt !== false) {
                    $published_at = $dt->format('Y-m-d H:i:s');
                } else {
                    $published_at = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $published_at)));
                }
            } else {
                $published_at = date('Y-m-d H:i:s', strtotime($published_at));
            }
        }
        $slug = $this->makeUniqueSlug($judul);

        // If status is published and no published_at provided, set to now
        if ($status === 'published' && ($published_at === null || $published_at === '')) {
            $published_at = date('Y-m-d H:i:s');
        }

        $data = [
            'judul' => $judul,
            'slug' => $slug,
            'isi' => $isi,
            'status' => $status,
            'published_at' => $published_at,
            'views' => 0,
        ];

        $tagIds = $this->request->getPost('tag_ids') ?? [];
        if (!is_array($tagIds)) {
            $tagIds = [$tagIds];
        }

        $model = new ArtikelModel();
        $artikelId = $model->insert($data, true);
        if ($artikelId === false) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(422)->setJSON([
                    'success' => false,
                    'errors' => $model->errors(),
                    'message' => 'Gagal menambahkan artikel!',
                ]);
            }
            return redirect()->back()->with('errors', $model->errors())
                ->with('danger', 'Gagal menambahkan artikel!')->withInput();
        }

        $this->saveArticleTags($artikelId, $tagIds);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Artikel berhasil ditambahkan!',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }

        return redirect()->to('admin/artikel')->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $model = new ArtikelModel();
        $id = (int) $id;
        if (!$id || $id <= 0) {
            return redirect()->to('admin/artikel')->with('danger', 'Invalid artikel ID!');
        }

        $artikel = $model->find($id);
        if (!$artikel) {
            return redirect()->to('admin/artikel')->with('danger', 'Artikel tidak ditemukan!');
        }

        return view('admin/artikel_form', [
            'title' => 'Edit Artikel',
            'artikel' => $artikel,
            'url' => 'update',
            'tags' => $this->getAllTags(),
            'selectedTags' => $this->getSelectedTagIds($id),
        ]);
    }

    public function update()
    {
        $id = (int) $this->request->getPost('id');
        if (!$id || $id <= 0) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(400)->setJSON([
                    'success' => false,
                    'message' => 'Invalid artikel ID!',
                ]);
            }
            return redirect()->back()->with('danger', 'Invalid artikel ID!');
        }

        $model = new ArtikelModel();
        $existing = $model->find($id);
        $oldStatus = $existing->status ?? null;

        $published_at = $this->request->getPost('published_at');

        if ($published_at === '' || $published_at === null) {
            $published_at = null;
        } else {
            // Convert HTML5 datetime-local (YYYY-MM-DDTHH:MM) to DB timestamp (YYYY-MM-DD HH:MM:SS)
            if (strpos($published_at, 'T') !== false) {
                $dt = \DateTime::createFromFormat('Y-m-d\\TH:i', $published_at);
                if ($dt !== false) {
                    $published_at = $dt->format('Y-m-d H:i:s');
                } else {
                    $published_at = date('Y-m-d H:i:s', strtotime(str_replace('T', ' ', $published_at)));
                }
            } else {
                $published_at = date('Y-m-d H:i:s', strtotime($published_at));
            }
        }

        $judul = strip_tags(trim($this->request->getPost('judul')));
        $isi = $this->sanitizeHtmlContent($this->request->getPost('isi'));
        $status = $this->request->getPost('status') === 'published' ? 'published' : 'draft';

        if ($published_at === '') {
            $published_at = null;
        }

        $slug = $this->makeUniqueSlug($judul, $id);

        // If changing from non-published to published and no published_at provided, set to now
        if ($status === 'published' && $oldStatus !== 'published' && ($published_at === null || $published_at === '')) {
            $published_at = date('Y-m-d H:i:s');
        }

        $data = [
            'judul' => $judul,
            'slug' => $slug,
            'isi' => $isi,
            'status' => $status,
            'published_at' => $published_at,
        ];

        // Ensure the current id is available for validation placeholder {id}
        $data['id'] = $id;

        $tagIds = $this->request->getPost('tag_ids') ?? [];
        if (!is_array($tagIds)) {
            $tagIds = [$tagIds];
        }

        $model = new ArtikelModel();
        if (!$model->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setStatusCode(422)->setJSON([
                    'success' => false,
                    'errors' => $model->errors(),
                    'message' => 'Gagal mengupdate artikel!',
                ]);
            }
            dd($model->errors());
            return redirect()->back()->with('errors', $model->errors())
                ->with('danger', 'Gagal mengupdate artikel!')->withInput();
        }

        $this->saveArticleTags($id, $tagIds);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Artikel berhasil diupdate!',
                'csrf_token' => csrf_token(),
                'csrf_hash' => csrf_hash(),
            ]);
        }

        return redirect()->to('admin/artikel')->with('success', 'Artikel berhasil diupdate!');
    }

    public function addTag()
    {
        $nama = strip_tags(trim($this->request->getPost('nama')));
        if ($nama === '') {
            return $this->response->setStatusCode(422)->setJSON([
                'success' => false,
                'message' => 'Nama tag tidak boleh kosong.',
            ]);
        }

        $slug = $this->makeUniqueTagSlug($nama);
        $tagModel = new TagArtikelModel();
        $tagId = $tagModel->insert([
            'nama' => $nama,
            'slug' => $slug,
        ], true);

        if ($tagId === false) {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Gagal menyimpan tag.',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'tag' => $tagModel->find($tagId),
            'tags' => $this->getAllTags(),
            'csrf_token' => csrf_token(),
            'csrf_hash' => csrf_hash(),
        ]);
    }

    public function delete()
    {
        $id = (int) $this->request->getPost('id');
        if (!$id || $id <= 0) {
            return redirect()->back()->with('danger', 'Invalid artikel ID!');
        }

        $model = new ArtikelModel();
        $artikel = $model->find($id);
        if (!$artikel) {
            return redirect()->back()->with('danger', 'Artikel tidak ditemukan!');
        }

        if (!$model->delete($id)) {
            return redirect()->back()->with('danger', 'Gagal menghapus artikel!');
        }

        return redirect()->to('admin/artikel')->with('success', 'Artikel berhasil dihapus!');
    }
}
