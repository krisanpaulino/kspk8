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
        'cerita_judul' => 'required',
        'cerita_isi' => 'required',
        'cerita_status' => 'required',
        'alumni_nim' => 'required',
        'cerita_nama' => 'required'
    ];
    protected $validationMessages   = [];
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
        $this->join('alumni', 'alumni.alumni_nim = cerita.alumni_nim');
        return $this->find($alumni_id);
    }
}
