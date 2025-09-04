<?php

namespace App\Models;

use CodeIgniter\Model;

class TanamanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'tanaman';
    protected $primaryKey       = 'tanaman_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'tanaman_nama',
        'tanaman_detail',
        'tanaman_penyakit',
        'tanaman_perawatan',
        'petani_id',
        'tanaman_gambar'
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'tanaman_nama' => 'required',
        'tanaman_detail' => 'required',
        'tanaman_penyakit' => 'required',
        'tanaman_gambar' => 'required'
        // 'tanaman_perawatan'
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

    public function findCount()
    {
        $this->select('count(*) as jumlah');
        return $this->first()->jumlah;
    }
    function byPetani($petani_id)
    {
        $this->join('petani', 'petani.petani_id = tanaman.petani_id', 'left');
        $this->where('petani.petani_id', $petani_id);
        return $this->find();
    }
    function getAll()
    {
        $this->join('petani', 'petani.petani_id = tanaman.petani_id', 'left');
        return $this->find();
    }
    function getSingle($tanaman_id)
    {
        $this->where('tanaman_id', $tanaman_id);
        $this->join('petani', 'petani.petani_id = tanaman.petani_id', 'left');
        return $this->first();
    }
    function search($search = null)
    {
        $this->select('tanaman.*, petani.*, count(komentar.komentar_id) as jumlahkomentar');
        $this->join('petani', 'petani.petani_id = tanaman.petani_id', 'left');
        $this->join('komentar', 'komentar.tanaman_id = tanaman.tanaman_id', 'left');
        $this->groupBy('tanaman.tanaman_id');
        if ($search != null)
            $this->like('tanaman_nama', $search);
        return $this->find();
    }
}
