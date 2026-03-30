<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Barang Model
 * File: app/Models/BarangModel.php
 * 
 * Handles all database operations for the 'barang' table.
 */
class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'nama_barang',
        'kategori',
        'jumlah',
        'harga',
    ];

    protected $useTimestamps  = true;
    protected $createdField   = 'created_at';
    protected $updatedField   = 'updated_at';

    // Validation rules
    protected $validationRules = [
        'nama_barang' => 'required|min_length[2]|max_length[100]',
        'kategori'    => 'required|min_length[2]|max_length[50]',
        'jumlah'      => 'required|integer|greater_than_equal_to[0]',
        'harga'       => 'required|decimal|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'nama_barang' => [
            'required'   => 'Nama barang wajib diisi.',
            'min_length' => 'Nama barang minimal 2 karakter.',
            'max_length' => 'Nama barang maksimal 100 karakter.',
        ],
        'kategori' => [
            'required'   => 'Kategori wajib diisi.',
            'min_length' => 'Kategori minimal 2 karakter.',
            'max_length' => 'Kategori maksimal 50 karakter.',
        ],
        'jumlah' => [
            'required'              => 'Jumlah wajib diisi.',
            'integer'               => 'Jumlah harus berupa angka.',
            'greater_than_equal_to' => 'Jumlah tidak boleh negatif.',
        ],
        'harga' => [
            'required'              => 'Harga wajib diisi.',
            'decimal'               => 'Harga harus berupa angka desimal.',
            'greater_than_equal_to' => 'Harga tidak boleh negatif.',
        ],
    ];

    /**
     * Get all barang records ordered by latest first.
     */
    public function getAllBarang(): array
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    /**
     * Get a single barang by ID.
     */
    public function getBarangById(int $id): ?array
    {
        return $this->find($id);
    }

    /**
     * Insert new barang.
     */
    public function insertBarang(array $data): bool|int
    {
        return $this->insert($data, true);
    }

    /**
     * Update existing barang.
     */
    public function updateBarang(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    /**
     * Delete a barang by ID.
     */
    public function deleteBarang(int $id): bool
    {
        return $this->delete($id);
    }
}
