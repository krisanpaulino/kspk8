<?php

namespace App\Models;

use CodeIgniter\Model;

class AgendaModel extends Model
{
    protected $table            = 'agenda';
    protected $primaryKey       = 'agenda_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'agenda_judul',
        'agenda_tanggal',
        'agenda_waktu',
        'agenda_deskripsi'
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
        'agenda_judul' => 'required|min_length[3]|max_length[255]|alpha_numeric_space',
        'agenda_tanggal' => 'required|valid_date',
        'agenda_waktu' => 'required|max_length[20]',
        'agenda_deskripsi' => 'required|min_length[10]'
    ];
    protected $validationMessages   = [
        'agenda_judul' => [
            'required' => 'Judul agenda harus diisi',
            'min_length' => 'Judul agenda minimal 3 karakter',
            'max_length' => 'Judul agenda maksimal 255 karakter',
            'alpha_numeric_space' => 'Judul agenda hanya boleh mengandung huruf, angka, dan spasi'
        ],
        'agenda_deskripsi' => [
            'required' => 'Deskripsi agenda harus diisi',
            'min_length' => 'Deskripsi agenda minimal 10 karakter'
        ],
        'agenda_tanggal' => [
            'required' => 'Tanggal agenda harus diisi',
            'valid_date' => 'Format tanggal tidak valid'
        ],
        'agenda_waktu' => [
            'required' => 'Waktu agenda harus diisi',
            'max_length' => 'Waktu agenda maksimal 20 karakter'
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

    function findAgenda()
    {
        $this->orderBy('agenda_id', 'desc');
        $result = $this->find();
        return $result;
    }
}
