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

        // Validate and sanitize alumni_id
        $alumni_id = (int) $alumni_id;
        if (!$alumni_id || $alumni_id <= 0) {
            return redirect()->to('admin/alumni')->with('danger', 'Invalid alumni ID!');
        }

        $alumni = $model->findSingle($alumni_id);
        if (!$alumni) {
            return redirect()->to('admin/alumni')->with('danger', 'Alumni tidak ditemukan!');
        }

        $data = [
            'title' => 'Detail',
            'prodi' => $mprodi->findAll(),
            'alumni' => $alumni
        ];
        return view('admin/alumni_detail', $data);
    }

    function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $file = $this->request->getFile('alumnni_foto');
        $model = new AlumniModel();
        $data = $this->request->getPost();

        // Sanitize input data
        if (isset($data['alumni_nama'])) {
            $data['alumni_nama'] = strip_tags(trim($data['alumni_nama']));
        }
        if (isset($data['alumni_nim'])) {
            $data['alumni_nim'] = preg_replace('/[^a-zA-Z0-9]/', '', trim($data['alumni_nim']));
        }
        if (isset($data['alumni_email'])) {
            $data['alumni_email'] = filter_var(trim($data['alumni_email']), FILTER_SANITIZE_EMAIL);
        }
        if (isset($data['alumni_telepon'])) {
            $data['alumni_telepon'] = preg_replace('/[^0-9+\-\s]/', '', trim($data['alumni_telepon']));
        }
        if (isset($data['alumni_tahunlulus'])) {
            $data['alumni_tahunlulus'] = (int) $data['alumni_tahunlulus'];
        }

        if ($model->insert($data)) {
            return redirect()->to('admin/alumni')
                ->with('success', 'Data alumni berhasil disimpan!');
        } else {
            $errors = $model->errors();
            return redirect()->back()
                ->with('danger', 'Data Gagal Disimpan. Cek Kembali Data Yang Dimasukkan!')
                ->with('errors', $errors)
                ->withInput();
        }
    }

    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $data = $this->request->getPost();
        $model = new AlumniModel();

        // Validate alumni_id
        $alumni_id = (int) $data['alumni_id'];
        if (!$alumni_id || $alumni_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid alumni ID!');
        }

        // Sanitize input data
        if (isset($data['alumni_nama'])) {
            $data['alumni_nama'] = strip_tags(trim($data['alumni_nama']));
        }
        if (isset($data['alumni_nim'])) {
            $data['alumni_nim'] = preg_replace('/[^a-zA-Z0-9]/', '', trim($data['alumni_nim']));
        }
        if (isset($data['alumni_email'])) {
            $data['alumni_email'] = filter_var(trim($data['alumni_email']), FILTER_SANITIZE_EMAIL);
        }
        if (isset($data['alumni_telepon'])) {
            $data['alumni_telepon'] = preg_replace('/[^0-9+\-\s]/', '', trim($data['alumni_telepon']));
        }
        if (isset($data['alumni_tahunlulus'])) {
            $data['alumni_tahunlulus'] = (int) $data['alumni_tahunlulus'];
        }

        if ($model->update($alumni_id, $data)) {
            return redirect()->back()->with('success', 'Data Alumni Berhasil Disimpan!');
        }
        return redirect()->back()
            ->with('errors', $model->errors())
            ->with('danger', 'Data gagal disimpan!')
            ->withInput();
    }

    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $alumni_id = (int) $this->request->getPost('alumni_id');

        // Validate alumni_id
        if (!$alumni_id || $alumni_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid alumni ID!');
        }

        $model = new AlumniModel();

        // Check if record exists
        $alumni = $model->find($alumni_id);
        if (!$alumni) {
            return redirect()->back()->with('danger', 'Alumni tidak ditemukan!');
        }

        $deleted = $model->delete($alumni_id);

        if ($deleted) {
            return redirect()->back()->with('success', 'Data alumni dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data alumni!');
        }
    }

    public function uploadExcel()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $file_excel = $this->request->getFile('file');

        // Validate file
        if (!$file_excel || !$file_excel->isValid()) {
            return redirect()->back()->with('danger', 'File tidak valid!');
        }

        $ext = $file_excel->getClientExtension();
        if (!in_array($ext, ['xls', 'xlsx'])) {
            return redirect()->back()->with('danger', 'Format file harus XLS atau XLSX!');
        }

        // Check file size (max 5MB)
        if ($file_excel->getSize() > 5 * 1024 * 1024) {
            return redirect()->back()->with('danger', 'File terlalu besar! Maksimal 5MB');
        }

        try {
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }

            $spreadsheet = $render->load($file_excel);
            $data = $spreadsheet->getActiveSheet()->toArray();

            $model = new AlumniModel();
            $successCount = 0;
            $errorCount = 0;

            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue; // Skip header row
                }

                // Validate and sanitize data
                $alumni_nim = preg_replace('/[^a-zA-Z0-9]/', '', trim($row[0] ?? ''));
                $prodi_id = strip_tags(trim($row[1] ?? ''));
                $alumni_tahunlulus = (int) ($row[2] ?? 0);
                $alumni_nama = strip_tags(trim($row[3] ?? ''));
                $jenis_kelamin = in_array($row[5] ?? '', ['L', 'P']) ? $row[5] : '-';
                $alumni_telepon = preg_replace('/[^0-9+\-\s]/', '', trim($row[6] ?? '-'));
                $alumni_email = filter_var(trim($row[7] ?? '-'), FILTER_SANITIZE_EMAIL);

                // Skip row if essential data is missing
                if (empty($alumni_nim) || empty($alumni_nama) || $alumni_tahunlulus < 1900) {
                    $errorCount++;
                    continue;
                }

                $insert = [
                    'alumni_nim' => $alumni_nim,
                    'prodi_id' => $prodi_id,
                    'alumni_tahunlulus' => $alumni_tahunlulus,
                    'alumni_nama' => $alumni_nama,
                    'alumni_jeniskelamin' => $jenis_kelamin,
                    'alumni_telepon' => $alumni_telepon,
                    'alumni_email' => $alumni_email,
                ];

                // Check if alumni already exists
                if ($model->findByNim($insert['alumni_nim']) == null) {
                    if ($model->insert($insert)) {
                        $successCount++;
                    } else {
                        $errorCount++;
                    }
                }
            }

            $message = "Upload selesai! Berhasil: $successCount, Error: $errorCount";
            return redirect()->back()->with('success', $message);
        } catch (Exception $e) {
            log_security_event('Excel upload failed', [
                'error' => $e->getMessage(),
                'file' => $file_excel->getName()
            ]);
            return redirect()->back()->with('danger', 'Gagal memproses file Excel!');
        }
    }
}
