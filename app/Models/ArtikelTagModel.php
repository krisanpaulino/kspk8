<?php

namespace App\Models;

use CodeIgniter\Model;

class ArtikelTagModel extends Model
{
    protected $table = 'artikel_tag';
    protected $primaryKey = 'artikel_id';
    protected $returnType = 'array';
    protected $allowedFields = ['artikel_id', 'tag_id'];
    protected $useTimestamps = false;

    public function getTagIdsByArtikel(int $artikelId): array
    {
        return $this->select('tag_id')
            ->where('artikel_id', $artikelId)
            ->findColumn('tag_id') ?: [];
    }

    public function saveTags(int $artikelId, array $tagIds): void
    {
        $builder = $this->builder();
        $builder->where('artikel_id', $artikelId)->delete();

        $data = [];
        foreach ($tagIds as $tagId) {
            $tagId = (int) $tagId;
            if ($tagId <= 0) {
                continue;
            }
            $data[] = ['artikel_id' => $artikelId, 'tag_id' => $tagId];
        }

        if (!empty($data)) {
            $builder->insertBatch($data);
        }
    }
}
