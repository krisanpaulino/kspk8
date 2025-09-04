<?php

namespace App\Models;

use CodeIgniter\Model;

class CetakModel extends Model
{
    protected $table            = 'cetak';
    protected $primaryKey       = 'cetak_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'alumni_nim',
        // 'cetak_tanggal',
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
        'alumni_nim' => 'required',
        // 'cetak_tanggal' => 'required',
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

    function findCetak()
    {
        $this->orderBy('cetak_id', 'desc');
        $result = $this->find();
        return $result;
    }
    function tersedia($alumni_nim)
    {
        $this->where('alumni_nim', $alumni_nim);
        $count = $this->countAllResults();
        if ($count < 2)
            return true;
        return false;
    }
}
