<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Alumni extends BaseController
{
    public function index()
    {
        $model = new AlumniModel();
        $mprodi = new ProdiModel();
        $data = [
            'title' => 'Alumni',
            'prodi' => $mprodi->findAll(),
            'alumni' => $model->findAlumni()
        ];
        return view('admin/alumni_index', $data);
    }
    public function detail($alumni_id)
    {
        $model = new AlumniModel();
        $mprodi = new ProdiModel();
        $alumni = $model->findSingle($alumni_id);
        $data = [
            'title' => 'Detail',
            'prodi' => $mprodi->findAll(),
            'alumni' => $alumni
        ];
        return view('admin/alumni_detail', $data);
    }
    function insert()
    {
        $file = $this->request->getFile('alumnni_foto');


        $model = new AlumniModel();
        $data = $this->request->getPost();

        // if (!empty($file)) {
        //     try {
        //         $filename = $file->getRandomName();
        //         $path = './assets/img/alumni';
        //         $file->move($path, $filename, true);
        //         $data['alumni_foto'] = $filename;
        //     } catch (Exception $e) {
        //         return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. Foto tidak valid!!')->withInput();
        //     }
        // }
        if ($model->insert($data)) {
            return redirect()->to('admin/alumni')
                ->with('success', 'Data alumni berhasil disimpan!');
        } else {
            $errors = $model->errors();
            dd($errors);
            return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. Cek Kembali Data Yang Dimasukkan!!')->with('errors', $errors)->withInput();
        }
    }
    public function update()
    {
        $data = $this->request->getPost();
        $model = new AlumniModel();
        // $file = $this->requests->getFile('alumni_foto');
        // if (!empty($file)) {
        //     try {
        //         $filename = $file->getRandomName();
        //         $path = './assets/img/alumni';
        //         $file->move($path, $filename, true);
        //         $data['alumni_foto'] = $filename;
        //     } catch (Exception $e) {
        //         return redirect()->to(previous_url())->with('danger', 'Data Gagal Disimpan. Foto tidak valid!!')->withInput();
        //     }
        // }
        if ($model->update($data['alumni_id'], $data)) {
            return redirect()->back()->with('success', 'Data Alumni Berhasil Disimpan!');
        }
        return redirect()->to(previous_url())->with('errors', $model->errors())->with('danger', 'Data gagal disimpan!');
    }
    function delete()
    {
        $alumni_id = $this->request->getPost('alumni_id');
        $model = new AlumniModel();
        $model->where('alumni_id', $alumni_id);
        $model->delete();
        return redirect()->back()->with('success', 'Data alumni dihapus!');
    }

    public function uploadExcel()
    {
        $file_excel = $this->request->getFile('file');
        $ext = $file_excel->getClientExtension();
        if ($ext == 'xls') {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
            $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);

        $data = $spreadsheet->getActiveSheet()->toArray();
        foreach ($data as $x => $row) {
            if ($x == 0) {
                continue;
            }

            $jenis_kelamin = $row[5] == null ? '-' : $row[5];
            $alumni_telepon = $row[6] == null ? '-' : $row[6];
            $alumni_email = $row[7] == null ? '-' : $row[7];
            $insert = [
                'alumni_nim' => $row[0],
                'prodi_id' => $row[1],
                'alumni_tahunlulus' => $row[2],
                'alumni_nama' => $row[3],
                'alumni_jeniskelamin' => $jenis_kelamin,
                'alumni_telepon' => $alumni_telepon,
                'alumni_email' => $alumni_email,
            ];
            // dd($insert);

            $model = new AlumniModel();

            // dd($model->findByNim($insert['alumni_nim']));
            if ($model->findByNim($insert['alumni_nim']) == null) {
                if (!$id = $model->insert($insert)) {
                    $errors = $model->errors();
                    dd($errors);
                }
            }
        }

        return redirect()->back()->with('success', 'Data alumni berhasil diupload!');
    }
}
