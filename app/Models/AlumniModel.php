<?php

namespace App\Models;

use CodeIgniter\Model;

class AlumniModel extends Model
{
    protected $table            = 'alumni';
    protected $primaryKey       = 'alumni_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'alumni_nim',
        'prodi_id',
        'alumni_tahunlulus',
        'alumni_nama',
        'alumni_jeniskelamin',
        'alumni_telepon',
        'alumni_email',
        'alumni_foto',
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
        'prodi_id' => 'required',
        'alumni_tahunlulus' => 'required',
        'alumni_nama' => 'required',
        // 'alumni_jeniskelamin' => 'required',
        // 'alumni_telepon' => 'required',
        // 'alumni_email' => 'required',
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

    function findAlumni($tahunlulus = null, $prodi_id = null)
    {
        $this->join('prodi', 'prodi.prodi_id = alumni.prodi_id');
        if ($tahunlulus != null)
            $this->where('alumni_tahunlulus', $tahunlulus);
        if ($prodi_id != null)
            $this->where('prodi_id', $prodi_id);
        $result = $this->findAll();
        return $result;
    }
    function findSingle($alumni_id)
    {
        $this->join('prodi', 'prodi.prodi_id = alumni.prodi_id', 'left');
        $result = $this->find($alumni_id);
        return $result;
    }
    function findByNim($alumni_nim)
    {
        $this->where('alumni_nim', $alumni_nim);
        $result = $this->first();
        return $result;
    }
    function findTahun()
    {
        $this->select('alumni_tahunlulus');
        $this->groupBy('alumni_tahunlulus');
        $result = $this->find();
        return $result;
    }
    function jumlah($limit = null, $param = null)
    {
        if ($param != null) {
            $this->where($param);
        }
        return $this->countAllResults();
    }
    function countTahun($limit = null)
    {
        $this->select('alumni_tahunlulus, COUNT(alumni_id) as jumlah');
        $this->groupBy('alumni_tahunlulus');
        $this->limit(5);
        $this->orderBy('alumni_tahunlulus', 'desc');

        if ($limit != null) {
            $this->limit($limit);
        }
        return $this->find();
    }
}
