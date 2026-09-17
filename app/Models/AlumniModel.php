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
    protected $afterInsert    = ['invalidateStatsCache'];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = ['invalidateStatsCache'];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = ['invalidateStatsCache'];

    public const CACHE_KEY_JUMLAH = 'alumni_jumlah';
    public const CACHE_KEY_COUNT_TAHUN = 'alumni_count_tahun';
    public const CACHE_TTL = 31536000;

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
        $this->where('alumni_tahunlulus >', 0);
        $this->groupBy('alumni_tahunlulus');
        $this->orderBy('alumni_tahunlulus', 'DESC');
        $result = $this->find();
        return $result;
    }
    function jumlah($limit = null, $param = null)
    {
        if ($param != null) {
            $this->where($param);
            return $this->countAllResults();
        }

        return cache()->remember(self::CACHE_KEY_JUMLAH, self::CACHE_TTL, function () {
            return $this->countAllResults();
        });
    }

    function countTahun($limit = null)
    {
        $cacheKey = $this->countTahunCacheKey($limit);

        return cache()->remember($cacheKey, self::CACHE_TTL, function () use ($limit) {
            $this->select('alumni_tahunlulus, COUNT(alumni_id) as jumlah');
            $this->groupBy('alumni_tahunlulus');
            $this->orderBy('alumni_tahunlulus', 'desc');

            if ($limit != null) {
                $this->limit($limit);
            } else {
                $this->limit(5);
            }

            return $this->find();
        });
    }

    public function getCachedStats(): array
    {
        return [
            'alumni'       => $this->jumlah(),
            'chart_alumni' => $this->countTahun(5),
            'tahunalumni'  => $this->countTahun(),
        ];
    }

    public function refreshStatsCache(): void
    {
        $this->clearStatsCache();
        $this->getCachedStats();
    }

    public function clearStatsCache(): void
    {
        $cache = cache();
        $cache->delete(self::CACHE_KEY_JUMLAH);
        $cache->delete($this->countTahunCacheKey());
        $cache->delete($this->countTahunCacheKey(5));
    }

    protected function invalidateStatsCache(array $data)
    {
        if (! empty($data['result'])) {
            $this->clearStatsCache();
        }

        return $data;
    }

    protected function countTahunCacheKey($limit = null): string
    {
        $effectiveLimit = $limit != null ? (int) $limit : 5;

        return self::CACHE_KEY_COUNT_TAHUN . '_' . $effectiveLimit;
    }

    public function parseFilters(array $params): array
    {
        $prodiId = preg_replace('/[^a-zA-Z0-9]/', '', trim((string) ($params['prodi_id'] ?? '')));
        $tahun = (int) ($params['tahunlulus'] ?? 0);
        if ($tahun < 1900 || $tahun > 2100) {
            $tahun = 0;
        }

        return [
            'prodi_id'    => $prodiId,
            'tahunlulus'  => $tahun,
        ];
    }

    public function countByFilter(array $filters): int
    {
        $builder = $this->db->table($this->table);
        $this->applyListFilters($builder, $filters);

        return $builder->countAllResults();
    }

    public function deleteByFilter(array $filters): int
    {
        $filters = $this->parseFilters($filters);
        if ($filters['prodi_id'] === '' && $filters['tahunlulus'] === 0) {
            return 0;
        }

        $count = $this->countByFilter($filters);
        if ($count === 0) {
            return 0;
        }

        $builder = $this->db->table($this->table);
        $this->applyListFilters($builder, $filters);
        $builder->delete();

        return $count;
    }

    public function getDatatable(array $params): array
    {
        $columns = [
            0 => 'alumni.alumni_nama',
            1 => 'alumni.alumni_nim',
            2 => 'prodi.prodi_nama',
            3 => 'alumni.alumni_jeniskelamin',
            4 => 'alumni.alumni_tahunlulus',
            5 => 'alumni.alumni_id',
        ];

        $draw   = (int) ($params['draw'] ?? 0);
        $start  = max(0, (int) ($params['start'] ?? 0));
        $length = (int) ($params['length'] ?? 10);
        if ($length < 1 || $length > 100) {
            $length = 10;
        }

        $search = trim((string) ($params['search']['value'] ?? ''));
        if (mb_strlen($search) > 100) {
            $search = mb_substr($search, 0, 100);
        }

        $filters    = $this->parseFilters($params);
        $orderCol   = (int) ($params['order'][0]['column'] ?? 0);
        $orderField = $columns[$orderCol] ?? 'alumni.alumni_nama';
        $orderDir   = strtolower((string) ($params['order'][0]['dir'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';

        $recordsTotal = $this->db->table($this->table)->countAllResults();

        $filteredBuilder = $this->db->table($this->table);
        $filteredBuilder->join('prodi', 'prodi.prodi_id = alumni.prodi_id', 'left');
        $this->applyListFilters($filteredBuilder, $filters, true);
        $this->applyDatatableSearch($filteredBuilder, $search);

        $hasFilter = $filters['prodi_id'] !== '' || $filters['tahunlulus'] !== 0;
        if ($search === '' && ! $hasFilter) {
            $recordsFiltered = $recordsTotal;
        } else {
            $recordsFiltered = $filteredBuilder->countAllResults();
        }

        $dataBuilder = $this->db->table($this->table);
        $dataBuilder->join('prodi', 'prodi.prodi_id = alumni.prodi_id', 'left');
        $this->applyListFilters($dataBuilder, $filters, true);
        $this->applyDatatableSearch($dataBuilder, $search);
        $rows = $dataBuilder
            ->select('alumni.alumni_id, alumni.alumni_nama, alumni.alumni_nim, alumni.alumni_jeniskelamin, alumni.alumni_tahunlulus, prodi.prodi_nama')
            ->orderBy($orderField, $orderDir)
            ->limit($length, $start)
            ->get()
            ->getResult();

        $data = [];
        foreach ($rows as $row) {
            $data[] = [
                'alumni_id'           => (int) $row->alumni_id,
                'alumni_nama'         => esc($row->alumni_nama),
                'alumni_nim'          => esc($row->alumni_nim),
                'prodi_nama'          => esc($row->prodi_nama ?? '-'),
                'alumni_jeniskelamin' => esc($row->alumni_jeniskelamin ?? '-'),
                'alumni_tahunlulus'   => esc($row->alumni_tahunlulus ?? '-'),
            ];
        }

        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ];
    }

    private function applyListFilters($builder, array $filters, bool $prefixed = false)
    {
        $prodiCol = $prefixed ? 'alumni.prodi_id' : 'prodi_id';
        $tahunCol = $prefixed ? 'alumni.alumni_tahunlulus' : 'alumni_tahunlulus';

        if (($filters['prodi_id'] ?? '') !== '') {
            $builder->where($prodiCol, $filters['prodi_id']);
        }
        if ((int) ($filters['tahunlulus'] ?? 0) >= 1900) {
            $builder->where($tahunCol, (int) $filters['tahunlulus']);
        }

        return $builder;
    }

    private function applyDatatableSearch($builder, string $search)
    {
        if ($search === '') {
            return $builder;
        }

        return $builder->groupStart()
            ->like('alumni.alumni_nama', $search)
            ->orLike('alumni.alumni_nim', $search)
            ->orLike('alumni.alumni_jeniskelamin', $search)
            ->orLike('alumni.alumni_tahunlulus', $search)
            ->orLike('prodi.prodi_nama', $search)
            ->groupEnd();
    }
}
