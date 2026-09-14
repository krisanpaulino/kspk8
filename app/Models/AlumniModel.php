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
        $this->groupBy('alumni_tahunlulus');
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

    public function getDatatable(array $params): array
    {
        $columns = [
            0 => 'alumni_nama',
            1 => 'alumni_nim',
            2 => 'alumni_jeniskelamin',
            3 => 'alumni_tahunlulus',
            4 => 'alumni_id',
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

        $orderCol   = (int) ($params['order'][0]['column'] ?? 0);
        $orderField = $columns[$orderCol] ?? 'alumni_nama';
        $orderDir   = strtolower((string) ($params['order'][0]['dir'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';

        $recordsTotal = $this->db->table($this->table)->countAllResults();

        if ($search === '') {
            $recordsFiltered = $recordsTotal;
        } else {
            $filteredBuilder = $this->db->table($this->table);
            $this->applyDatatableSearch($filteredBuilder, $search);
            $recordsFiltered = $filteredBuilder->countAllResults();
        }

        $dataBuilder = $this->db->table($this->table);
        $this->applyDatatableSearch($dataBuilder, $search);
        $rows = $dataBuilder
            ->select('alumni_id, alumni_nama, alumni_nim, alumni_jeniskelamin, alumni_tahunlulus')
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
                'alumni_jeniskelamin' => esc($row->alumni_jeniskelamin ?? '-'),
                'alumni_tahunlulus'   => esc($row->alumni_tahunlulus),
            ];
        }

        return [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $data,
        ];
    }

    private function applyDatatableSearch($builder, string $search)
    {
        if ($search === '') {
            return $builder;
        }

        return $builder->groupStart()
            ->like('alumni_nama', $search)
            ->orLike('alumni_nim', $search)
            ->orLike('alumni_jeniskelamin', $search)
            ->orLike('alumni_tahunlulus', $search)
            ->groupEnd();
    }
}
