<?php

namespace App\Models;

use CodeIgniter\Model;

class CeritaModel extends Model
{
    protected $table            = 'cerita';
    protected $primaryKey       = 'cerita_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'cerita_judul',
        'cerita_isi',
        'cerita_tanggal',
        'cerita_status',
        'alumni_nim',
        'cerita_nama'
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
        'cerita_judul' => 'required|min_length[5]|max_length[200]',
        'cerita_isi' => 'required|min_length[10]',
        'cerita_status' => 'required|in_list[pending,approved,rejected]',
        'cerita_nama' => 'required|min_length[2]|max_length[100]|alpha_space',
        'alumni_nim' => 'permit_empty|max_length[20]|alpha_numeric'
    ];
    protected $validationMessages   = [
        'cerita_judul' => [
            'required' => 'Judul cerita harus diisi',
            'min_length' => 'Judul cerita minimal 5 karakter',
            'max_length' => 'Judul cerita maksimal 200 karakter'
        ],
        'cerita_isi' => [
            'required' => 'Isi cerita harus diisi',
            'min_length' => 'Isi cerita minimal 10 karakter'
        ],
        'cerita_nama' => [
            'required' => 'Nama alumni harus diisi',
            'min_length' => 'Nama alumni minimal 2 karakter',
            'max_length' => 'Nama alumni maksimal 100 karakter',
            'alpha_space' => 'Nama alumni hanya boleh mengandung huruf dan spasi'
        ],
        'cerita_status' => [
            'required' => 'Status cerita harus diisi',
            'in_list' => 'Status cerita tidak valid'
        ],
        'alumni_nim' => [
            'max_length' => 'NIM maksimal 20 karakter',
            'alpha_numeric' => 'NIM hanya boleh mengandung huruf dan angka'
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

    function findCerita($status = null)
    {
        $this->orderBy('cerita_tanggal', 'desc');
        $this->join('alumni', 'alumni.alumni_nim = cerita.alumni_nim', 'left');
        $this->groupBy('cerita_id');
        if ($status != null)
            $this->where('cerita_status', $status);
        return $this->find();
    }
    function findSingle($alumni_id)
    {
        $this->join('alumni', 'alumni.alumni_nim = cerita.alumni_nim', 'left');
        return $this->find($alumni_id);
    }
}
