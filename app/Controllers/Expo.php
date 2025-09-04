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

        $data = [
            'title' => 'Detail',
            'url' => 'update',
            'expo' => $model->find($expo_id),
        ];
        return view('admin/expo_form', $data);
    }
    function insert()
    {
        $model = new ExpoModel();
        $data = $this->request->getPost();

        $doc = new DOMDocument();
        @$doc->loadHTML($data['expo_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['expo_gambar'] = $image;
            $model = new ExpoModel();
            if ($model->insert($data)) {
                return redirect()->to('admin/expo')
                    ->with('success', 'Data kerjsama berhasil disimpan!!');
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
    public function update()
    {
        $expo_id = $this->request->getPost('expo_id');
        $data = $this->request->getPost();
        $model = new ExpoModel();
        $doc = new DOMDocument();
        @$doc->loadHTML($data['expo_isi']);

        $tags = $doc->getElementsByTagName('img');

        if ($tags->count() > 0) {
            $url = $tags[0]->getAttribute('src');
            $pathinfo = pathinfo($url);
            $image = $pathinfo['filename'] . '.' . $pathinfo['extension'];
            $data['expo_gambar'] = $image;
            if ($model->update($expo_id, $data)) {
                return redirect()->back()
                    ->with('success', 'Data expo berhasil disimpan!!');
            } else {
                return redirect()->back()
                    ->with('errors', $model->errors())
                    ->with('danger', 'Periksa kembali data expo!')
                    ->withInput();
            }
            // dd($image);
        } else {
            return redirect()->back()
                ->with('danger', 'Detail expo harus ada gambar!')
                ->withInput();
        }
    }
    function delete()
    {
        $expo_id = $this->request->getPost('expo_id');
        $model = new ExpoModel();
        $model->where('expo_id', $expo_id);
        $model->delete();
        return redirect()->back()->with('success', 'Data expo dihapus!');
    }
}
