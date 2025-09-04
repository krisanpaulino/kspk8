<?php

namespace App\Models;

use CodeIgniter\Model;

class KarierModel extends Model
{
    protected $table            = 'karier';
    protected $primaryKey       = 'karier_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'karier_judul',
        'karier_tanggal',
        'karier_flyer',
        'karier_isi'
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
        'karier_judul' => 'required',
        'karier_tanggal' => 'required',
        'karier_flyer' => 'required',
        'karier_isi' => 'required'
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

    function findkarier()
    {
        $this->orderBy('karier_id', 'desc');
        $result = $this->find();
        return $result;
    }
}
