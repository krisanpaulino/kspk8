<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AlumniModel;
use App\Models\ProdiModel;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Alumni extends BaseController
{
    public function index()
    {
        $mprodi = new ProdiModel();
        $model = new AlumniModel();
        $data = [
            'title' => 'Alumni',
            'prodi' => $mprodi->orderBy('prodi_nama', 'ASC')->findAll(),
            'tahun' => $model->findTahun(),
        ];
        return view('admin/alumni_index', $data);
    }

    public function datatable()
    {
        $model = new AlumniModel();

        return $this->response->setJSON($model->getDatatable($this->request->getGet()));
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
            $model->refreshStatsCache();
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
            $model->refreshStatsCache();
            return redirect()->back()->with('success', 'Data Alumni Berhasil Disimpan!');
        }
        return redirect()->back()
            ->with('errors', $model->errors())
            ->with('danger', 'Data gagal disimpan!')
            ->withInput();
    }

    function delete()
    {

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
            $model->refreshStatsCache();
            return redirect()->back()->with('success', 'Data alumni dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data alumni!');
        }
    }

    public function deleteFiltered()
    {
        $model = new AlumniModel();
        $filters = $model->parseFilters($this->request->getPost());

        if ($filters['prodi_id'] === '' && $filters['tahunlulus'] === 0) {
            return redirect()->back()->with('danger', 'Pilih filter prodi atau tahun lulus sebelum menghapus data.');
        }

        $deleted = $model->deleteByFilter($filters);
        if ($deleted > 0) {
            $model->refreshStatsCache();
            return redirect()->back()->with('success', $deleted . ' data alumni sesuai filter berhasil dihapus.');
        }

        return redirect()->back()->with('danger', 'Tidak ada data alumni yang sesuai filter.');
    }

    public function downloadTemplate()
    {
        $prodiModel = new ProdiModel();
        $prodiList = $prodiModel->orderBy('prodi_nama', 'ASC')->findAll();

        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Data Alumni');
        $sheet->fromArray([
            'NIM',
            'Kode Prodi',
            'Tahun Lulus',
            'Nama',
            'Tempat Lahir (opsional)',
            'Jenis Kelamin (L/P)',
            'No HP',
            'Email',
        ], null, 'A1');

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '0D6EFD'],
            ],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A1:H1')->applyFromArray($headerStyle);
        $sheet->freezePane('A2');

        foreach (range('A', 'H') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $jkValidation = new DataValidation();
        $jkValidation->setType(DataValidation::TYPE_LIST);
        $jkValidation->setAllowBlank(true);
        $jkValidation->setShowDropDown(true);
        $jkValidation->setFormula1('"L,P"');
        $jkValidation->setShowErrorMessage(true);
        $jkValidation->setErrorTitle('Nilai tidak valid');
        $jkValidation->setError('Jenis kelamin harus L atau P.');
        $sheet->setDataValidation('F2:F1000', $jkValidation);

        $prodiSheet = $spreadsheet->createSheet();
        $prodiSheet->setTitle('Daftar Prodi');
        $prodiSheet->fromArray(['Kode Prodi', 'Nama Prodi'], null, 'A1');
        $prodiSheet->getStyle('A1:B1')->applyFromArray($headerStyle);
        $prodiSheet->freezePane('A2');

        $prodiRow = 2;
        foreach ($prodiList as $prodi) {
            $prodiSheet->setCellValue('A' . $prodiRow, $prodi->prodi_id);
            $prodiSheet->setCellValue('B' . $prodiRow, $prodi->prodi_nama);
            $prodiRow++;
        }

        $prodiSheet->getColumnDimension('A')->setAutoSize(true);
        $prodiSheet->getColumnDimension('B')->setAutoSize(true);

        if ($prodiRow > 2) {
            $lastProdiRow = $prodiRow - 1;
            $prodiValidation = new DataValidation();
            $prodiValidation->setType(DataValidation::TYPE_LIST);
            $prodiValidation->setAllowBlank(false);
            $prodiValidation->setShowDropDown(true);
            $prodiValidation->setFormula1('\'Daftar Prodi\'!$A$2:$A$' . $lastProdiRow);
            $prodiValidation->setShowErrorMessage(true);
            $prodiValidation->setErrorTitle('Kode Prodi tidak valid');
            $prodiValidation->setError('Pilih kode prodi dari sheet Daftar Prodi.');
            $sheet->setDataValidation('B2:B1000', $prodiValidation);
        }

        $guideSheet = $spreadsheet->createSheet();
        $guideSheet->setTitle('Petunjuk');
        $guideSheet->fromArray([
            ['Petunjuk pengisian template alumni'],
            [''],
            ['1. Isi data hanya pada sheet Data Alumni, mulai dari baris ke-2.'],
            ['2. Jangan menghapus baris header dan jangan mengubah urutan kolom.'],
            ['3. Kolom wajib: NIM, Kode Prodi, dan Nama. Kolom lain boleh dikosongkan.'],
            ['4. Kode Prodi harus sesuai daftar pada sheet Daftar Prodi.'],
            ['5. Jenis Kelamin opsional, isi L (Laki-laki) atau P (Perempuan) jika diisi.'],
            ['6. Kolom Tempat Lahir, Tahun Lulus, No HP, dan Email bersifat opsional.'],
            ['7. NIM yang sudah ada di sistem akan dilewati saat upload.'],
            ['8. Contoh baris: 20210001 | 010101 | 2024 | Nama Alumni |  | L | 081234567890 | alumni@email.com'],
        ], null, 'A1');
        $guideSheet->getStyle('A1')->getFont()->setBold(true);
        $guideSheet->getColumnDimension('A')->setWidth(110);

        $spreadsheet->setActiveSheetIndex(0);

        $filename = 'template_alumni.xlsx';
        $writer = new Xlsx($spreadsheet);

        ob_start();
        $writer->save('php://output');
        $excelOutput = ob_get_clean();

        return $this->response
            ->setHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setHeader('Cache-Control', 'max-age=0')
            ->setBody($excelOutput);
    }

    public function uploadExcel()
    {

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
            $model->skipValidation(true);
            $prodiModel = new ProdiModel();
            $prodiIds = [];
            foreach ($prodiModel->findAll() as $prodi) {
                $prodiIds[$prodi->prodi_id] = true;
            }

            $successCount = 0;
            $errorCount = 0;
            $skipCount = 0;
            $notes = [];
            $maxNotes = 50;

            foreach ($data as $x => $row) {
                if ($x == 0) {
                    continue; // Skip header row
                }

                $excelRow = $x + 1;
                $alumni_nim = preg_replace('/[^a-zA-Z0-9]/', '', trim((string) ($row[0] ?? '')));
                $prodi_id = strip_tags(trim((string) ($row[1] ?? '')));
                $alumni_nama = strip_tags(trim((string) ($row[3] ?? '')));

                if ($alumni_nim === '' && $prodi_id === '' && $alumni_nama === '') {
                    continue;
                }

                $missing = [];
                if ($alumni_nim === '') {
                    $missing[] = 'NIM';
                }
                if ($prodi_id === '') {
                    $missing[] = 'Kode Prodi';
                }
                if ($alumni_nama === '') {
                    $missing[] = 'Nama';
                }

                if ($missing !== []) {
                    $errorCount++;
                    $this->pushUploadNote($notes, $maxNotes, 'Baris ' . $excelRow . ': kolom wajib kosong (' . implode(', ', $missing) . ').');
                    continue;
                }

                if (! isset($prodiIds[$prodi_id])) {
                    $errorCount++;
                    $this->pushUploadNote($notes, $maxNotes, 'Baris ' . $excelRow . ': kode prodi "' . $prodi_id . '" tidak ditemukan.');
                    continue;
                }

                $tahunRaw = trim((string) ($row[2] ?? ''));
                $alumni_tahunlulus = ($tahunRaw !== '' && (int) $tahunRaw >= 1900) ? (int) $tahunRaw : null;
                $jenis_kelamin = in_array($row[5] ?? '', ['L', 'P'], true) ? $row[5] : '-';
                $teleponRaw = preg_replace('/[^0-9+\-\s]/', '', trim((string) ($row[6] ?? '')));
                $alumni_telepon = $teleponRaw !== '' ? $teleponRaw : '-';
                $emailRaw = filter_var(trim((string) ($row[7] ?? '')), FILTER_SANITIZE_EMAIL);
                $alumni_email = $emailRaw !== '' ? $emailRaw : '-';

                $insert = [
                    'alumni_nim' => $alumni_nim,
                    'prodi_id' => $prodi_id,
                    'alumni_tahunlulus' => $alumni_tahunlulus,
                    'alumni_nama' => $alumni_nama,
                    'alumni_jeniskelamin' => $jenis_kelamin,
                    'alumni_telepon' => $alumni_telepon,
                    'alumni_email' => $alumni_email,
                ];

                if ($model->findByNim($insert['alumni_nim']) != null) {
                    $skipCount++;
                    $this->pushUploadNote($notes, $maxNotes, 'Baris ' . $excelRow . ': NIM ' . $alumni_nim . ' sudah terdaftar, dilewati.');
                    continue;
                }

                if ($model->insert($insert)) {
                    $successCount++;
                } else {
                    $errorCount++;
                    $reason = implode(', ', $model->errors() ?: ['gagal menyimpan']);
                    $this->pushUploadNote($notes, $maxNotes, 'Baris ' . $excelRow . ': gagal menyimpan NIM ' . $alumni_nim . ' (' . $reason . ').');
                }
            }

            if ($successCount > 0) {
                $model->refreshStatsCache();
            }

            $hiddenNotes = max(0, ($errorCount + $skipCount) - count($notes));
            if ($hiddenNotes > 0) {
                $notes[] = 'Dan ' . $hiddenNotes . ' catatan lainnya tidak ditampilkan.';
            }

            $message = "Upload selesai! Berhasil: $successCount, Gagal: $errorCount, Dilewati: $skipCount";
            $redirect = redirect()->back()->with('success', $message);
            if ($notes !== []) {
                $redirect = $redirect->with('upload_notes', $notes);
            }

            return $redirect;
        } catch (Exception $e) {
            log_security_event('Excel upload failed', [
                'error' => $e->getMessage(),
                'file' => $file_excel->getName()
            ]);
            return redirect()->back()->with('danger', 'Gagal memproses file Excel!');
        }
    }

    private function pushUploadNote(array &$notes, int $maxNotes, string $note): void
    {
        if (count($notes) < $maxNotes) {
            $notes[] = $note;
        }
    }
}
