<?php

namespace App\Models;

use CodeIgniter\Model;

class BeritaModel extends Model
{
    protected $table            = 'berita';
    protected $primaryKey       = 'berita_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'berita_tanggal',
        'berita_judul',
        'berita_thumbnail',
        'berita_isi',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'berita_tanggal' => 'required|valid_date',
        'berita_judul' => 'required|min_length[3]|max_length[255]|alpha_numeric_space',
        'berita_isi' => 'required|min_length[10]',
        'berita_thumbnail' => 'permit_empty|max_length[255]'
    ];
    protected $validationMessages   = [
        'berita_judul' => [
            'required' => 'Judul berita harus diisi',
            'min_length' => 'Judul berita minimal 3 karakter',
            'max_length' => 'Judul berita maksimal 255 karakter',
            'alpha_numeric_space' => 'Judul berita hanya boleh mengandung huruf, angka, dan spasi'
        ],
        'berita_isi' => [
            'required' => 'Isi berita harus diisi',
            'min_length' => 'Isi berita minimal 10 karakter'
        ],
        'berita_tanggal' => [
            'required' => 'Tanggal berita harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
