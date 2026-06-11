<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelModel extends Model
{
    protected $table = 'artikel';
    protected $primaryKey = 'id';
    protected $returnType = 'object';
    protected $allowedFields = ['judul', 'slug', 'isi', 'thumbnail', 'status', 'published_at', 'views'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'judul' => 'required|min_length[5]|max_length[255]',
        'slug' => 'required|max_length[255]|is_unique[artikel.slug,id,{id}]',
        'isi' => 'required|min_length[10]',
        'status' => 'required|in_list[draft,published]',
        'published_at' => 'permit_empty|valid_date[Y-m-d H:i:s]|valid_date[Y-m-d\TH:i]|valid_date[Y/m/d H:i:s]',
    ];
    protected $validationMessages = [
        'judul' => [
            'required' => 'Judul artikel harus diisi',
            'min_length' => 'Judul artikel minimal 5 karakter',
            'max_length' => 'Judul artikel maksimal 255 karakter',
        ],
        'slug' => [
            'required' => 'Slug artikel diperlukan',
            'is_unique' => 'Slug artikel sudah digunakan',
        ],
        'isi' => [
            'required' => 'Isi artikel harus diisi',
            'min_length' => 'Isi artikel minimal 10 karakter',
        ],
        'status' => [
            'required' => 'Status artikel harus diisi',
            'in_list' => 'Status artikel tidak valid',
        ],
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    public function getTags($artikelId)
    {
        return $this->db->table('tag_artikel t')
            ->join('artikel_tag at', 't.id = at.tag_id')
            ->where('at.artikel_id', $artikelId)
            ->get()
            ->getResultArray();
    }
}
