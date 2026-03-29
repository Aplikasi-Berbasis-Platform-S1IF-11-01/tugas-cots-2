<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Jersey Model — CI4
 * Operasi CRUD untuk tabel jerseys
 */
class JerseyModel extends Model
{
    protected $table      = 'jerseys';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    // Kolom yang boleh diisi (mass assignment)
    protected $allowedFields = [
        'kode', 'nama', 'klub', 'liga', 'musim',
        'ukuran', 'jenis', 'harga', 'stok',
        'deskripsi', 'gambar', 'status',
    ];

    // Timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Aturan validasi (server-side via Model)
    protected $validationRules = [
        'kode'   => 'required|max_length[20]',
        'nama'   => 'required|max_length[150]',
        'klub'   => 'required|max_length[100]',
        'liga'   => 'required|max_length[100]',
        'musim'  => 'required|max_length[20]',
        'ukuran' => 'required|in_list[S,M,L,XL,XXL]',
        'jenis'  => 'required|in_list[Home,Away,Third,GK,Training]',
        'harga'  => 'required|numeric|greater_than[0]',
        'stok'   => 'required|integer|greater_than_equal_to[0]',
        'status' => 'required|in_list[Aktif,Nonaktif]',
    ];

    protected $validationMessages = [
        'kode'   => ['required' => 'Kode jersey wajib diisi'],
        'nama'   => ['required' => 'Nama jersey wajib diisi'],
        'klub'   => ['required' => 'Nama klub wajib diisi'],
        'liga'   => ['required' => 'Liga wajib diisi'],
        'musim'  => ['required' => 'Musim wajib diisi'],
        'ukuran' => ['required' => 'Ukuran wajib dipilih', 'in_list' => 'Ukuran tidak valid'],
        'jenis'  => ['required' => 'Jenis jersey wajib dipilih'],
        'harga'  => ['required' => 'Harga wajib diisi', 'greater_than' => 'Harga harus lebih dari 0'],
        'stok'   => ['required' => 'Stok wajib diisi'],
        'status' => ['required' => 'Status wajib dipilih'],
    ];

    protected $skipValidation = false;

    // ─────────────────────────────────────────
    // Data untuk jQuery DataTable (JSON)
    // ─────────────────────────────────────────
    public function getDataTable(string $search, int $orderCol, string $orderDir, int $start, int $length): array
    {
        $columns = ['id', 'kode', 'nama', 'klub', 'liga', 'musim', 'ukuran', 'jenis', 'harga', 'stok', 'status'];
        $orderBy = $columns[$orderCol] ?? 'id';

        $builder = $this->db->table($this->table);

        // Filter pencarian
        if (!empty($search)) {
            $builder->groupStart()
                ->like('kode', $search)
                ->orLike('nama', $search)
                ->orLike('klub', $search)
                ->orLike('liga', $search)
                ->orLike('musim', $search)
                ->orLike('jenis', $search)
                ->orLike('status', $search)
                ->groupEnd();
        }

        $totalFiltered = $builder->countAllResults(false);

        $data = $builder->orderBy($orderBy, $orderDir)
            ->limit($length, $start)
            ->get()
            ->getResult();

        return [
            'data'           => $data,
            'totalFiltered'  => $totalFiltered,
            'totalAll'       => $this->countAll(),
        ];
    }

    // ─────────────────────────────────────────
    // Statistik untuk Dashboard
    // ─────────────────────────────────────────
    public function countAktif(): int
    {
        return $this->where('status', 'Aktif')->countAllResults();
    }

    public function totalStok(): int
    {
        $row = $this->db->table($this->table)->selectSum('stok')->get()->getRow();
        return $row ? (int)$row->stok : 0;
    }

    public function getLigaStats(): array
    {
        return $this->db->table($this->table)
            ->select('liga, COUNT(*) as jumlah')
            ->groupBy('liga')
            ->orderBy('jumlah', 'DESC')
            ->get()
            ->getResult();
    }

    // ─────────────────────────────────────────
    // Generate kode otomatis
    // ─────────────────────────────────────────
    public function generateKode(): string
    {
        $row = $this->db->table($this->table)->selectMax('id')->get()->getRow();
        $nextId = ($row && $row->id) ? (int)$row->id + 1 : 1;
        return 'JRS-' . str_pad($nextId, 3, '0', STR_PAD_LEFT);
    }
}
