<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BeritaModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;

class Berita extends BaseController
{
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

        // Proses Data Sekolah
        $databerita = $this->request->getPost();
        // dd($this->request->getFile('file'));

        //Insert data to Sekolah
        //find images
        $doc = new DOMDocument();
        @$doc->loadHTML($databerita['berita_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $databerita['berita_thumbnail'] = $image;
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

        // Proses Data Sekolah
        $berita_id = $this->request->getPost('berita_id');
        $databerita = $this->request->getPost();
        // dd($this->request->getFile('file'));

        //Insert data to Sekolah
        //find images
        $doc = new DOMDocument();
        @$doc->loadHTML($databerita['berita_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $databerita['berita_thumbnail'] = $image;
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
        $berita_id = $this->request->getPost('berita_id');
        // dd($berita_id);
        $model = new BeritaModel();
        $model->where('berita_id', $berita_id);
        $model->delete();
        return redirect()->back()
            ->with('message', "Toastify({'text':'Berita dihapus!'}).showToast()");
    }
}
