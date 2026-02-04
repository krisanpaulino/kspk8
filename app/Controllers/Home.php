<?php

namespace App\Controllers;

use App\Models\AgendaModel;
use App\Models\AlumniModel;
use App\Models\BeritaModel;
use App\Models\ExpoModel;
use App\Models\CeritaModel;
use App\Models\CetakModel;
use App\Models\KarierModel;
use App\Models\KerjasamaModel;
use App\Models\PageModel;
use DOMDocument;
use Dompdf\Dompdf;
use Dompdf\Options;

class Home extends BaseController
{
    public function index()
    {
        $beritaModel = new BeritaModel();
        $agendaModel = new AgendaModel();
        $alumniModel = new AlumniModel();

        $data['title'] = 'KSPK UNWIRA - Home';
        $data['berita'] = $beritaModel->orderBy('berita_tanggal', 'DESC')->findAll(3);
        $data['agenda'] = $agendaModel->orderBy('agenda_id', 'DESC')->findAll(3);
        $data['alumni'] = $alumniModel->jumlah();
        $data['chart_alumni'] = $alumniModel->countTahun(5);
        $data['tahunalumni'] = $alumniModel->countTahun();

        return view('user/home', $data);
    }

    public function page($tag)
    {
        $pageModel = new PageModel();

        $data['title'] = 'KSPK UNWIRA - Page';
        $data['page'] = $pageModel->where('page_tag', $tag)->first();
        return view('user/page', $data);
    }

    public function detailberita($id)
    {
        $beritaModel = new BeritaModel();

        $data['title'] = 'KSPK UNWIRA - Berita';
        $data['berita'] = $beritaModel->where('berita_id', $id)->first();
        return view('user/detailberita', $data);
    }

    public function detailagenda($id)
    {
        $agendaModel = new AgendaModel();

        $data['title'] = 'KSPK UNWIRA - Agenda';
        $data['agenda'] = $agendaModel->where('agenda_id', $id)->first();
        return view('user/detailagenda', $data);
    }

    public function kerjasama($jenis)
    {
        $kerjasamaModel = new KerjasamaModel();

        $data['title'] = 'KSPK UNWIRA - Kerja sama';
        $data['jenis'] = $jenis;

        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $data['kerjasama'] = $kerjasamaModel
            ->where('kerjasama_jenis', $jenis)
            ->orderBy('kerjasama_id', 'DESC')
            ->paginate(12, 'paginasi');
        $data['pager'] = $kerjasamaModel->pager;
        return view('user/kerjasama', $data);
    }

    public function detailkerjasama($id)
    {
        $kerjasamaModel = new KerjasamaModel();

        $data['title'] = 'KSPK UNWIRA - Kerja sama';
        $data['kerjasama'] = $kerjasamaModel->where('kerjasama_id', $id)->first();
        return view('user/detailkerjasama', $data);
    }

    public function berita()
    {
        $beritaModel = new BeritaModel();

        $data['title'] = 'KSPK UNWIRA - Berita';

        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $data['berita'] = $beritaModel
            ->orderBy('berita_id', 'DESC')
            ->paginate(12, 'paginasi');
        $data['pager'] = $beritaModel->pager;
        return view('user/berita', $data);
    }

    public function agenda()
    {
        $agendaModel = new AgendaModel();

        $data['title'] = 'KSPK UNWIRA - Agenda';

        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $data['agenda'] = $agendaModel
            ->orderBy('agenda_id', 'DESC')
            ->paginate(12, 'paginasi');
        $data['pager'] = $agendaModel->pager;
        return view('user/agenda', $data);
    }

    public function alumni()
    {
        $alumniModel = new AlumniModel();

        $data['title'] = 'KSPK UNWIRA - Alumni';
        $data['alumni'] = $alumniModel->orderBy('alumni_tahunlulus', 'DESC')->findAll();
        return view('user/alumni', $data);
    }

    public function alumnidownload()
    {
        $alumniModel = new AlumniModel();
        $data['alumni'] = $alumniModel->orderBy('alumni_tahunlulus', 'DESC')->findAll(2000);

        $html = view('user/alumni-download', $data);

        $dompdf = new Dompdf();
        ini_set('memory_limit', '1024M');
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('alumni_download.pdf', array('Attachment' => 0));
    }

    public function kartualumni()
    {
        $data['title'] = 'KSPK UNWIRA - Kartu alumni';

        return view('user/kartu_alumni', $data);
    }

    public function cetakkartu()
    {
        // Validate CSRF token first
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('error', 'Invalid security token!');
        }

        // Rate limiting for card printing
        $clientIP = $this->request->getIPAddress();
        $cacheKey = 'print_attempts_' . md5($clientIP);
        $cache = \Config\Services::cache();

        $attempts = $cache->get($cacheKey) ?? 0;
        if ($attempts >= 5) { // Max 5 attempts per hour
            return redirect()->back()->with('error', 'Terlalu banyak percobaan cetak. Coba lagi dalam 1 jam.');
        }

        $alumniModel = new AlumniModel();
        $cetakModel = new CetakModel();
        $nim = trim($this->request->getPost('alumni_nim'));

        // Enhanced validation
        $validationRules = [
            'alumni_nim' => [
                'rules'  => 'required|min_length[5]|max_length[20]|alpha_numeric',
                'errors' => [
                    'required' => 'NIM alumni tidak boleh kosong!',
                    'min_length' => 'NIM minimal 5 karakter',
                    'max_length' => 'NIM maksimal 20 karakter',
                    'alpha_numeric' => 'NIM hanya boleh mengandung huruf dan angka'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            $cache->save($cacheKey, $attempts + 1, 3600);
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Sanitize input - remove any potential malicious characters
        $nim = preg_replace('/[^a-zA-Z0-9]/', '', $nim);

        $cekalumni = $alumniModel->where('alumni_nim', $nim)->countAllResults();

        if ($cekalumni > 0) {
            $dataalumni = $alumniModel->where('alumni_nim', $nim)->first();
            $prodiid = $dataalumni->prodi_id;

            $prodinama = '';
            if ($prodiid == '010101') {
                $prodinama = 'Bimbingan dan Konseling';
            } elseif ($prodiid == '010102') {
                $prodinama = 'PGSD';
            } elseif ($prodiid == '010102') {
                $prodinama = 'PGSD';
            } elseif ($prodiid == '010201') {
                $prodinama = 'Pendidikan Bahasa Inggris';
            } elseif ($prodiid == '010301') {
                $prodinama = 'Pendidikan Matematika';
            } elseif ($prodiid == '010401') {
                $prodinama = 'Pendidikan Biologi';
            } elseif ($prodiid == '010501') {
                $prodinama = 'Pendidikan Kimia';
            } elseif ($prodiid == '010601') {
                $prodinama = 'Pendidikan Fisika';
            } elseif ($prodiid == '010701') {
                $prodinama = 'Pendidikan Musik';
            } elseif ($prodiid == '020101') {
                $prodinama = 'Teknik Sipil';
            } elseif ($prodiid == '020201') {
                $prodinama = 'Arsitektur';
            } elseif ($prodiid == '020301') {
                $prodinama = 'Ilmu Komputer';
            } elseif ($prodiid == '030101') {
                $prodinama = 'Ekonomi Pembangunan';
            } elseif ($prodiid == '030201') {
                $prodinama = 'Manajemen (S1)';
            } elseif ($prodiid == '030301') {
                $prodinama = 'Akuntansi';
            } elseif ($prodiid == '040101') {
                $prodinama = 'Ilmu Pemerintahan';
            } elseif ($prodiid == '040201') {
                $prodinama = 'Administrasi Publik';
            } elseif ($prodiid == '040301') {
                $prodinama = 'Ilmu Komunikasi';
            } elseif ($prodiid == '050101') {
                $prodinama = 'Hukum';
            } elseif ($prodiid == '060101') {
                $prodinama = 'Ilmu Filsafat';
            } elseif ($prodiid == '070101') {
                $prodinama = 'Biologi';
            } elseif ($prodiid == '070201') {
                $prodinama = 'Kimia';
            } elseif ($prodiid == '070301') {
                $prodinama = 'Teknologi Pangan';
            } elseif ($prodiid == '080101') {
                $prodinama = 'Manajemen (S2)';
            } else {
                $prodinama = '-';
            }

            $cekcetak = $cetakModel->where('alumni_nim', $nim)->countAllResults();

            if ($cekcetak > 0) {
                $datacetak = $cetakModel->where('alumni_nim', $nim)->first();
                log_security_event('Duplicate card print attempt', [
                    'ip' => $clientIP,
                    'nim' => $nim,
                    'previous_print' => $datacetak->cetak_tanggal
                ]);
                return redirect()->back()->withInput()->with('error', 'Anda sudah pernah mencetak kartu alumni pada : ' . date('d-M-Y h:i:s', strtotime($datacetak->cetak_tanggal)) . '! Hubungi admin untuk proses lebih lanjut!');
            } else {
                // Log successful card generation
                log_security_event('Alumni card generated', [
                    'ip' => $clientIP,
                    'nim' => $nim
                ]);



                // CETAK PDF

                $data['alumni'] = $alumniModel->where('alumni_nim', $nim)->first();
                $data['prodi'] = $prodinama;
                $depan = new \CodeIgniter\Files\File('assets-user/image/template-card-depan.png');
                $belakang = new \CodeIgniter\Files\File('assets-user/image/template-card-belakang.png');
                $data['depan'] = base64_encode(file_get_contents(APPPATH . '/../assets-user/image/template-card-depan.png'));
                $data['belakang'] = base64_encode(file_get_contents(APPPATH . '/../assets-user/image/template-card-belakang.png'));
                $html = view('user/cetak-kartu', $data);
                // return view('user/cetak-kartu', $data);
                // dd();
                // dd($data['depan']);
                $options = new Options();
                $options->set('isRemoteEnabled', true);
                $options->set('isHtml5ParserEnabled', true);
                $options->set('isPhpEnabled', true);

                $dompdf = new Dompdf($options);

                ob_end_clean(); // Hapus buffer output agar tidak error
                $dompdf->loadHtml($html);

                $customPaper = [0, 0, 500, 300]; // 500px x 300px
                $dompdf->setPaper($customPaper);

                $dompdf->render();
                $dompdf->stream('kartu-alumni.pdf', ["Attachment" => false]);
                // $cetakModel->save([
                //     'cetak_tanggal'    => date('Y-m-d h:i:s'),
                //     'alumni_nim'       => $nim,
                // ]);
                exit;



                return redirect()->to('/kartualumni')->with('success', 'Data berhasil diproses! Kartu alumni anda akan didownload!');
            }
        } else {
            $cache->save($cacheKey, $attempts + 1, 3600);
            log_security_event('Invalid NIM attempt', [
                'ip' => $clientIP,
                'nim' => $nim
            ]);
            return redirect()->back()->withInput()->with('error', 'Data anda tidak ada! Hubungi admin untuk proses lebih lanjut!');
        }
    }

    public function cerita()
    {
        $ceritaModel = new CeritaModel();
        $data['title'] = 'KSPK UNWIRA - Cerita alumni';
        $data['cerita'] = $ceritaModel->where('cerita_status', 'approved')->orderBy('cerita_tanggal', 'DESC')->findAll();

        return view('user/cerita', $data);
    }

    public function detailcerita($id)
    {
        $ceritaModel = new CeritaModel();
        $data['title'] = 'KSPK UNWIRA - Detail cerita alumni';
        $data['cerita'] = $ceritaModel->where('cerita_id', $id)->first();

        return view('user/detailcerita', $data);
    }

    public function add_cerita()
    {
        $data['title'] = 'KSPK UNWIRA - Tambah cerita alumni';

        return view('user/add_cerita', $data);
    }

    function create_cerita()
    {
        // Validate CSRF token first
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        // Rate limiting for public submissions
        $clientIP = $this->request->getIPAddress();
        $cacheKey = 'cerita_submissions_' . md5($clientIP);
        $cache = \Config\Services::cache();

        $submissions = $cache->get($cacheKey) ?? 0;
        if ($submissions >= 3) { // Max 3 submissions per hour
            return redirect()->back()->with('danger', 'Terlalu banyak submission. Coba lagi dalam 1 jam.');
        }

        $ceritaModel = new CeritaModel();
        $validationRules = [
            'cerita_nama' => [
                'rules'  => 'required|min_length[2]|max_length[100]|alpha_space',
                'errors' => [
                    'required' => 'Nama alumni wajib diisi!',
                    'min_length' => 'Nama minimal 2 karakter',
                    'max_length' => 'Nama maksimal 100 karakter',
                    'alpha_space' => 'Nama hanya boleh mengandung huruf dan spasi'
                ]
            ],
            'cerita_judul' => [
                'rules'  => 'required|min_length[5]|max_length[200]',
                'errors' => [
                    'required' => 'Judul harus diisi!',
                    'min_length' => 'Judul minimal 5 karakter',
                    'max_length' => 'Judul maksimal 200 karakter'
                ]
            ],
            'cerita_isi' => [
                'rules'  => 'required|min_length[10]',
                'errors' => [
                    'required' => 'Isi cerita wajib diisi!',
                    'min_length' => 'Isi cerita minimal 10 karakter'
                ]
            ],
        ];

        if (!$this->validate($validationRules)) {
            $cache->save($cacheKey, $submissions + 1, 3600); // Track failed attempts too
            return redirect()->back()->withInput()->with('validation', $this->validator);
        }

        // Get and sanitize input data
        $ceritaNama = strip_tags(trim($this->request->getPost('cerita_nama')));
        $ceritaJudul = strip_tags(trim($this->request->getPost('cerita_judul')));
        $ceritaIsi = $this->sanitizeHtmlContent($this->request->getPost('cerita_isi'));

        // Additional validation - check for suspicious patterns
        $suspiciousPatterns = ['<script', 'javascript:', 'onclick', 'onerror', 'onload'];
        $combinedContent = $ceritaNama . ' ' . $ceritaJudul . ' ' . $ceritaIsi;

        foreach ($suspiciousPatterns as $pattern) {
            if (stripos($combinedContent, $pattern) !== false) {
                log_security_event('Suspicious content in cerita submission', [
                    'ip' => $clientIP,
                    'pattern' => $pattern,
                    'content_preview' => substr($combinedContent, 0, 100)
                ]);
                return redirect()->back()->with('danger', 'Konten tidak diizinkan terdeteksi!');
            }
        }

        $ceritaModel->save([
            'cerita_judul'      => $ceritaJudul,
            'cerita_isi'        => $ceritaIsi,
            'cerita_status'     => 'pending', // Always pending for public submissions
            'cerita_tanggal'    => date('Y-m-d H:i:s'),
            'cerita_nama'       => $ceritaNama,
        ]);

        // Track successful submission
        $cache->save($cacheKey, $submissions + 1, 3600); // 1 hour cache

        // Log the submission
        log_security_event('Public cerita submission', [
            'ip' => $clientIP,
            'nama' => $ceritaNama,
            'judul' => $ceritaJudul
        ]);

        return redirect()->to('/add_cerita')->with('success', 'Data berhasil ditambahkan! Cerita anda membutuhkan waktu dan persetujuan admin untuk dapat ditampilkan ke publik. Mohon menunggu...');
    }

    /**
     * Sanitize HTML content for public submissions - more restrictive than admin
     */
    private function sanitizeHtmlContent($html)
    {
        // For public submissions, only allow very basic formatting
        $allowedTags = '<p><br><strong><b><em><i><u>';

        // Strip all tags except allowed ones
        $html = strip_tags($html, $allowedTags);

        // Remove any remaining dangerous patterns
        $html = preg_replace('/javascript:/i', '', $html);
        $html = preg_replace('/on\w+\s*=/i', '', $html);
        $html = preg_replace('/style\s*=/i', '', $html);
        $html = preg_replace('/data-\w+\s*=/i', '', $html);
        $html = preg_replace('/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi', '', $html);

        return $html;
    }

    public function expo()
    {
        $expoModel = new ExpoModel();

        $data['title'] = 'KSPK UNWIRA - Expo';

        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $data['expo'] = $expoModel
            ->orderBy('expo_id', 'DESC')
            ->paginate(12, 'paginasi');
        $data['pager'] = $expoModel->pager;
        return view('user/expo', $data);
    }

    public function expodetail($id)
    {
        $expoModel = new ExpoModel();

        $data['title'] = 'KSPK UNWIRA - Expo';
        $data['expo'] = $expoModel->where('expo_id', $id)->first();
        return view('user/expodetail', $data);
    }

    public function karier()
    {
        $KarierModel = new KarierModel();

        $data['title'] = 'KSPK UNWIRA - Karier';

        $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;

        $data['karier'] = $KarierModel
            ->orderBy('karier_id', 'DESC')
            ->paginate(12, 'paginasi');
        $data['pager'] = $KarierModel->pager;
        return view('user/karier', $data);
    }

    public function karierdetail($id)
    {
        $KarierModel = new KarierModel();

        $data['title'] = 'KSPK UNWIRA - Karier';
        $data['karier'] = $KarierModel->where('karier_id', $id)->first();
        return view('user/karierdetail', $data);
    }
}
