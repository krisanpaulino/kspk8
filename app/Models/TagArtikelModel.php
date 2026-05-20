<?php

namespace App\Models;

use CodeIgniter\Model;

class TagArtikelModel extends Model
{
    protected $table = 'tag_artikel';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['nama', 'slug'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getArtikel($tagId)
    {
        return $this->db->table('artikel a')
            ->join('artikel_tag at', 'a.id = at.artikel_id')
            ->where('at.tag_id', $tagId)
            ->get()
            ->getResultArray();
    }
}
