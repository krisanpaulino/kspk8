<?php

namespace App\Models;

use CodeIgniter\Model;

class ExpoModel extends Model
{
    protected $table            = 'expo';
    protected $primaryKey       = 'expo_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'expo_judul',
        'expo_tanggal',
        'expo_tahun',
        'expo_periode',
        'expo_isi',
         'expo_gambar'

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
        'expo_judul' => 'required',
        'expo_tanggal' => 'required',
        'expo_tahun' => 'required',
        'expo_periode' => 'required',
        'expo_isi' => 'required'
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

    function findExpo()
    {
        $this->orderBy('expo_id', 'desc');
        $result = $this->find();
        return $result;
    }
}
