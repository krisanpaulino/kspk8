<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KarierModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Karier extends BaseController
{
    public function index()
    {
        $model = new KarierModel();
        $data = [
            'title' => 'Karier',
            'karier' => $model->findKarier()
        ];
        return view('admin/karier_index', $data);
    }
    public function detail($karier_id)
    {
        $model = new KarierModel();
        $karier = $model->find($karier_id);
        $data = [
            'title' => 'Detail Persiapan Karier',
            'karier' => $karier
        ];
        return view('admin/karier_detail', $data);
    }
    function insert()
    {
        $file = $this->request->getFile('karier_flyer');


        $model = new KarierModel();
        $data = $this->request->getPost();

        if (!empty($file)) {
            try {
                $filename = $file->getRandomName();
                $path = './assets/img/karier';
                $file->move($path, $filename, true);
                $data['karier_flyer'] = $filename;
            } catch (Exception $e) {
                return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. Foto tidak valid!!')->withInput();
            }
        }
        if ($model->insert($data)) {
            return redirect()->to('admin/karier')
                ->with('success', 'Data Karier berhasil disimpan!');
        } else {
            $errors = $model->errors();
            dd($model->errors());
            return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. Cek Kembali Data Yang Dimasukkan!!')->with('errors', $errors)->withInput();
        }
    }
    public function update()
    {
        $data = (array)$this->request->getPost();
        // unset($data['karier_flyer']);
        // dd($data);
        $model = new KarierModel();
        $karier = $model->find($data['karier_id']);
        $file = $this->request->getFile('karier_flyer');
        if (!empty($file)) {
            try {
                $filename = $file->getRandomName();
                $path = './assets/img/karier';
                $file->move($path, $filename, true);
                $data['karier_flyer'] = $filename;
            } catch (Exception $e) {
                return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. File FLyer valid!!')->withInput();
            }
        }
        // dd($data);

        if ($model->update($karier->karier_id, $data)) {
            return redirect()->back()->with('success', 'Data Karier Berhasil Disimpan!');
        }
        return redirect()->to(previous_url())->with('errors', $model->errors())->with('danger', 'Data gagal disimpan!');
    }
    function delete()
    {
        $karier_id = $this->request->getPost('karier_id');
        $model = new KarierModel();
        $model->where('karier_id', $karier_id);
        $model->delete();
        return redirect()->back()->with('success', 'Data Karier dihapus!');
    }
}
