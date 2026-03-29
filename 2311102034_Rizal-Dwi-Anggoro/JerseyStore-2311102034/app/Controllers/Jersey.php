<?php

namespace App\Controllers;

use App\Models\JerseyModel;
use CodeIgniter\Controller;

/**
 * Jersey Controller — CI4
 *
 * CRUD lengkap untuk data jersey
 * Halaman:
 *  index()  → Tabel DataTable (JSON)
 *  tambah() → Form tambah jersey
 *  simpan() → Proses create (POST)
 *  edit()   → Form edit jersey
 *  update() → Proses update (POST)
 *  hapus()  → Proses delete (AJAX)
 *  detail() → Detail jersey (AJAX Modal)
 *  json()   → Endpoint JSON untuk DataTable
 */
class Jersey extends BaseController
{
    protected JerseyModel $model;

    public function __construct()
    {
        // Model di-load di initController CI4
    }

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->model = new JerseyModel();
    }

    // ═══════════════════════════════════════════════════════════
    // HALAMAN 1: Tabel Data Jersey
    // ═══════════════════════════════════════════════════════════
    public function index(): string
    {
        $data = [
            'title'       => 'Data Jersey',
            'activeMenu'  => 'jersey',
            'total'       => $this->model->countAll(),
            'totalAktif'  => $this->model->countAktif(),
            'totalStok'   => $this->model->totalStok(),
        ];
        return view('layouts/header', $data)
             . view('jersey/index', $data)
             . view('layouts/footer');
    }

    // ═══════════════════════════════════════════════════════════
    // ENDPOINT JSON untuk jQuery DataTable
    // ═══════════════════════════════════════════════════════════
    public function json()
    {
        $request = service('request');

        $dataJersey = $this->model->findAll();

        $data = [];
        $no = 1;

        foreach ($dataJersey as $row) {

            $aksi = '
                <a href="' . base_url('jersey/edit/' . $row->id) . '" class="btn btn-sm btn-warning">
                    ✏️
                </a>
                <button class="btn btn-sm btn-danger btn-hapus"
                    data-id="' . $row->id . '"
                    data-nama="' . $row->nama . '">
                    🗑️
                </button>
            ';

            $data[] = [
                $no++,
                $row->kode,
                $row->nama,
                $row->liga,
                $row->musim,
                $row->ukuran,
                $row->jenis,
                'Rp ' . number_format($row->harga, 0, ',', '.'),
                $row->stok,
                $row->status,
                $aksi
            ];
        }

        return $this->response->setJSON([
            "draw" => intval($request->getPost('draw')),
            "recordsTotal" => count($data),
            "recordsFiltered" => count($data),
            "data" => $data
        ]);
    }

    // ═══════════════════════════════════════════════════════════
    // HALAMAN 2: Form Tambah Jersey (CREATE)
    // ═══════════════════════════════════════════════════════════
    public function tambah(): string
    {
        $data = [
            'title'      => 'Tambah Jersey',
            'activeMenu' => 'jersey',
            'autoKode'   => $this->model->generateKode(),
            'formAction' => base_url('jersey/simpan'),
            'mode'       => 'tambah',
            'jersey'     => null,
            'errors'     => [],
        ];
        return view('layouts/header', $data)
             . view('jersey/form', $data)
             . view('layouts/footer');
    }

    // ═══════════════════════════════════════════════════════════
    // PROSES: Simpan Data Baru (POST)
    // ═══════════════════════════════════════════════════════════
    public function simpan(): \CodeIgniter\HTTP\RedirectResponse|string
    {
        // Validasi input
        $rules = $this->_validationRules();
        if (!$this->validate($rules)) {
            $data = [
                'title'      => 'Tambah Jersey',
                'activeMenu' => 'jersey',
                'autoKode'   => $this->request->getPost('kode'),
                'formAction' => base_url('jersey/simpan'),
                'mode'       => 'tambah',
                'jersey'     => (object)$this->request->getPost(),
                'errors'     => $this->validator->getErrors(),
            ];
            return view('layouts/header', $data)
                 . view('jersey/form', $data)
                 . view('layouts/footer');
        }

        $this->model->skipValidation(true)->insert($this->_getFormData());
        return redirect()->to(base_url('jersey'))
            ->with('success', 'Jersey <strong>' . $this->request->getPost('nama') . '</strong> berhasil ditambahkan!');
    }

    // ═══════════════════════════════════════════════════════════
    // HALAMAN 3: Form Edit Jersey (UPDATE)
    // ═══════════════════════════════════════════════════════════
    public function edit(int $id): \CodeIgniter\HTTP\RedirectResponse|string
    {
        $jersey = $this->model->find($id);
        if (!$jersey) {
            return redirect()->to(base_url('jersey'))->with('error', 'Data jersey tidak ditemukan!');
        }

        $data = [
            'title'      => 'Edit Jersey',
            'activeMenu' => 'jersey',
            'autoKode'   => $jersey->kode,
            'formAction' => base_url('jersey/update/' . $id),
            'mode'       => 'edit',
            'jersey'     => $jersey,
            'errors'     => [],
        ];
        return view('layouts/header', $data)
             . view('jersey/form', $data)
             . view('layouts/footer');
    }

    // ═══════════════════════════════════════════════════════════
    // PROSES: Update Data (POST)
    // ═══════════════════════════════════════════════════════════
    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse|string
    {
        $jersey = $this->model->find($id);
        if (!$jersey) {
            return redirect()->to(base_url('jersey'))->with('error', 'Data tidak ditemukan!');
        }

        $rules = $this->_validationRules();
        if (!$this->validate($rules)) {
            $data = [
                'title'      => 'Edit Jersey',
                'activeMenu' => 'jersey',
                'autoKode'   => $this->request->getPost('kode'),
                'formAction' => base_url('jersey/update/' . $id),
                'mode'       => 'edit',
                'jersey'     => (object)array_merge((array)$jersey, $this->request->getPost()),
                'errors'     => $this->validator->getErrors(),
            ];
            return view('layouts/header', $data)
                 . view('jersey/form', $data)
                 . view('layouts/footer');
        }

        $this->model->skipValidation(true)->update($id, $this->_getFormData());
        return redirect()->to(base_url('jersey'))
            ->with('success', 'Jersey <strong>' . $this->request->getPost('nama') . '</strong> berhasil diperbarui!');
    }

    // ═══════════════════════════════════════════════════════════
    // PROSES: Hapus Data (DELETE via AJAX)
    // ═══════════════════════════════════════════════════════════
    public function hapus(int $id): \CodeIgniter\HTTP\Response|\CodeIgniter\HTTP\RedirectResponse
    {
        $jersey = $this->model->find($id);

        if (!$jersey) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan!']);
            }
            return redirect()->to(base_url('jersey'))->with('error', 'Data tidak ditemukan!');
        }

        $this->model->delete($id);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Jersey <strong>' . esc($jersey->nama) . '</strong> berhasil dihapus!',
            ]);
        }
        return redirect()->to(base_url('jersey'))->with('success', 'Jersey berhasil dihapus!');
    }

    // ═══════════════════════════════════════════════════════════
    // AJAX: Detail Jersey untuk Modal
    // ═══════════════════════════════════════════════════════════
    public function detail(int $id): \CodeIgniter\HTTP\Response
    {
        $jersey = $this->model->find($id);
        if (!$jersey) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
        return $this->response->setJSON(['status' => 'success', 'data' => $jersey]);
    }

    // ─────────────────────────────────────────
    // PRIVATE HELPERS
    // ─────────────────────────────────────────
    private function _validationRules(): array
    {
        return [
            'nama'   => 'required|min_length[3]|max_length[150]',
            'klub'   => 'required|max_length[100]',
            'liga'   => 'required|max_length[100]',
            'musim'  => 'required|max_length[20]',
            'ukuran' => 'required|in_list[S,M,L,XL,XXL]',
            'jenis'  => 'required|in_list[Home,Away,Third,GK,Training]',
            'harga'  => 'required|numeric|greater_than[0]',
            'stok'   => 'required|integer|greater_than_equal_to[0]',
            'status' => 'required|in_list[Aktif,Nonaktif]',
        ];
    }

    private function _getFormData(): array
    {
        return [
            'kode'      => trim($this->request->getPost('kode')),
            'nama'      => trim($this->request->getPost('nama')),
            'klub'      => trim($this->request->getPost('klub')),
            'liga'      => trim($this->request->getPost('liga')),
            'musim'     => trim($this->request->getPost('musim')),
            'ukuran'    => $this->request->getPost('ukuran'),
            'jenis'     => $this->request->getPost('jenis'),
            'harga'     => (float)$this->request->getPost('harga'),
            'stok'      => (int)$this->request->getPost('stok'),
            'deskripsi' => trim($this->request->getPost('deskripsi') ?? ''),
            'status'    => $this->request->getPost('status'),
        ];
    }
}
