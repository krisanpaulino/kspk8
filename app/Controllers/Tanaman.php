<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use DOMDocument;

class Berita extends BaseController
{
    public function index()
    {
        $model = new BeritaModel();
        if (session('user')->user_type == 'petani')
            $Berita = $model->byPetani(petani()->petani_id);
        else
            $Berita = $model->getAll();
        $data = [
            'title' => 'Data Berita',
            'Berita' => $Berita
        ];
        return view('Berita/index', $data);
    }
    public function tambah()
    {
        $Berita = new BeritaModel();
        $data['title'] = 'Tambah Berita';
        $data['form_title'] = 'Tambah Berita';
        $data['Berita'] = $Berita;
        return view('Berita/form', $data);
    }
    public function store()
    {
        $data = $this->request->getPost();
        $doc = new DOMDocument();
        @$doc->loadHTML($data['Berita_detail']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['Berita_gambar'] = $image;
            $model = new BeritaModel();
            if ($model->insert($data)) {
                return redirect()->to(session('user')->user_type . '/Berita')
                    ->with('success', 'Data Berita berhasil disimpan!!');
            }
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Periksa kembali data Berita!')
                ->withInput();
        } else {
            return redirect()->back()
                ->with('danger', 'Detail tamaman harus ada gambar!')
                ->withInput();
        }
    }
    public function update()
    {
        $Berita_id = $this->request->getPost('Berita_id');
        $data = $this->request->getPost();
        $model = new BeritaModel();
        $doc = new DOMDocument();
        @$doc->loadHTML($data['Berita_detail']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['Berita_gambar'] = $image;
            if ($model->update($Berita_id, $data)) {
                return redirect()->back()
                    ->with('success', 'Data Berita berhasil disimpan!!');
            } else {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->with('danger', 'Periksa kembali data Berita!')
                    ->withInput();
            }
            // dd($image);
        } else {
            return redirect()->back()
                ->with('danger', 'Detail tamaman harus ada gambar!')
                ->withInput();
        }
    }
    public function edit($Berita_id)
    {
        $model = new BeritaModel();
        $Berita = $model->find($Berita_id);

        $data = [
            'title' => 'Detail Berita',
            'Berita' => $Berita
        ];
        $data['form_title'] = 'Update Berita';

        return view('Berita/form', $data);
    }
    public function detail($Berita_id)
    {
        $model = new BeritaModel();
        $Berita = $model->getSingle($Berita_id);

        $data = [
            'title' => 'Detail Berita',
            'Berita' => $Berita
        ];

        return view('Berita/detail', $data);
    }
    public function delete()
    {
        $Berita_id = $this->request->getPost('Berita_id');
        $model = new BeritaModel();
        $model->where('Berita_id', $Berita_id);
        $model->delete();

        return redirect()->back()->with('success', 'Data Berita berhasil dihapus');
    }
    public function detailFront($Berita_id)
    {
        $model = new BeritaModel();
        $Berita = $model->find($Berita_id);

        $data = [
            'title' => 'Detail Berita',
            'Berita' => $Berita,
        ];

        return view('Berita_detail', $data);
    }
}
