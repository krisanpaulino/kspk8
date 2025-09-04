<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KerjasamaModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;
use Exception;

class Kerjasama extends BaseController
{
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

        $data = [
            'title' => 'Detail',
            'url' => 'update',
            'kerjasama' => $model->find($kerjasama_id),
        ];
        return view('admin/kerjasama_form', $data);
    }
    function insert()
    {
        $model = new KerjasamaModel();
        $data = $this->request->getPost();

        $doc = new DOMDocument();
        @$doc->loadHTML($data['kerjasama_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['kerjasama_gambar'] = $image;
            $model = new KerjasamaModel();
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
        $kerjasama_id = $this->request->getPost('kerjasama_id');
        $data = $this->request->getPost();
        $model = new KerjasamaModel();
        $doc = new DOMDocument();
        @$doc->loadHTML($data['kerjasama_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['kerjasama_gambar'] = $image;
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
        $kerjasama_id = $this->request->getPost('kerjasama_id');
        $model = new KerjasamaModel();
        $model->where('kerjasama_id', $kerjasama_id);
        $model->delete();
        return redirect()->back()->with('success', 'Data kerjasama dihapus!');
    }
}
