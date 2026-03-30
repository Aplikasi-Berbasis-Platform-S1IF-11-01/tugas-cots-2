<?php

namespace App\Controllers;

use App\Models\BarangModel;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Barang Controller
 * File: app/Controllers/Barang.php
 * 
 * Handles all CRUD operations for Inventaris Barang.
 * Uses AJAX for all data operations.
 */
class Barang extends BaseController
{
    protected BarangModel $barangModel; 
    public function __construct()
    {
        $this->barangModel = new BarangModel(); //supaya controller bisa mengakses database

    }

    // =========================================================
    // VIEW: Main page (DataTables + Modal form)
    // =========================================================

    /**
     * Main inventory page.
     * GET /barang
     */
    public function index(): string
    {
        $data = [
            'title'      => 'Inventaris Barang',
            'page_title' => 'Data Inventaris Barang',
        ];
        return view('barang/index', $data); //buka halaman
    }

    // =========================================================
    // READ: Return JSON data for DataTables
    // =========================================================

    /**
     * Return all barang as JSON for DataTables.
     * GET /barang/getData
     */
    public function getData(): ResponseInterface
    {
        $barang = $this->barangModel->getAllBarang(); //mengambil semua data barang dari database melalui model

        $result = [];
        $no = 1;

        foreach ($barang as $item) {
            $result[] = [
                'no'          => $no++,
                'id'          => $item['id'],
                'nama_barang' => esc($item['nama_barang']),
                'kategori'    => esc($item['kategori']),
                'jumlah'      => (int) $item['jumlah'],
                'harga'       => (float) $item['harga'],
                'harga_fmt'   => 'Rp ' . number_format((float)$item['harga'], 0, ',', '.'),
                'created_at'  => date('d/m/Y', strtotime($item['created_at'])),
            ];
        }

        return $this->response->setJSON([
            'data' => $result,
        ]); //Data dikirim dalam bentuk JSON ke browser
    }

    // =========================================================
    // CREATE: Store new barang
    // =========================================================

    /**
     * Store a new barang record via AJAX.
     * POST /barang/store
     */
    public function store(): ResponseInterface
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Forbidden: AJAX only.',
            ]);
        }

        $rules = [
            'nama_barang' => 'required|min_length[2]|max_length[100]',
            'kategori'    => 'required|min_length[2]|max_length[50]',
            'jumlah'      => 'required|integer|greater_than_equal_to[0]',
            'harga'       => 'required|decimal|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kategori'    => $this->request->getPost('kategori'),
            'jumlah'      => (int) $this->request->getPost('jumlah'),
            'harga'       => (float) $this->request->getPost('harga'),
        ];

        $inserted = $this->barangModel->insertBarang($data);

        if ($inserted) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Barang berhasil ditambahkan.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menambahkan barang. Silakan coba lagi.',
        ]);
    }

    // =========================================================
    // READ ONE: Get single barang for edit modal
    // =========================================================

    /**
     * Return single barang data as JSON for edit modal.
     * GET /barang/edit/{id}
     */
    public function edit(int $id): ResponseInterface
    {
        $barang = $this->barangModel->getBarangById($id);

        if (!$barang) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 'error',
                'message' => 'Data barang tidak ditemukan.',
            ]);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $barang,
        ]);
    }

    // =========================================================
    // UPDATE: Update existing barang
    // =========================================================

    /**
     * Update a barang record via AJAX.
     * POST /barang/update
     */
    public function update(): ResponseInterface
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Forbidden: AJAX only.',
            ]);
        }

        $id = (int) $this->request->getPost('id');

        if (!$id || !$this->barangModel->getBarangById($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data barang tidak ditemukan.',
            ]);
        }

        $rules = [
            'nama_barang' => 'required|min_length[2]|max_length[100]',
            'kategori'    => 'required|min_length[2]|max_length[50]',
            'jumlah'      => 'required|integer|greater_than_equal_to[0]',
            'harga'       => 'required|decimal|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $data = [
            'nama_barang' => $this->request->getPost('nama_barang'),
            'kategori'    => $this->request->getPost('kategori'),
            'jumlah'      => (int) $this->request->getPost('jumlah'),
            'harga'       => (float) $this->request->getPost('harga'),
        ];

        $updated = $this->barangModel->updateBarang($id, $data);

        if ($updated) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Barang berhasil diperbarui.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal memperbarui barang. Silakan coba lagi.',
        ]);
    }

    // =========================================================
    // DELETE: Remove barang
    // =========================================================

    /**
     * Delete a barang record via AJAX.
     * POST /barang/delete
     */
    public function delete(): ResponseInterface
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'status'  => 'error',
                'message' => 'Forbidden: AJAX only.',
            ]);
        }

        $id = (int) $this->request->getPost('id');

        if (!$id || !$this->barangModel->getBarangById($id)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Data barang tidak ditemukan.',
            ]);
        }

        $deleted = $this->barangModel->deleteBarang($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Barang berhasil dihapus.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Gagal menghapus barang. Silakan coba lagi.',
        ]);
    }
}
