<?php
namespace App\Controllers;
use App\Models\MobilModel;
use App\Models\PenjualModel;

class MobilController extends BaseController {
    protected $mobilModel;
    protected $penjualModel;

    public function __construct() {
        $this->mobilModel = new MobilModel();
        $this->penjualModel = new PenjualModel();
    }

    // Halaman tabel
    public function index() {
        return view('mobil/index');
    }

    // Endpoint JSON untuk DataTables (jQuery plugin)
    public function getJson() {
    $data = $this->mobilModel->getMobilWithPenjual();

    $result = array_map(function($row, $i) {
        return [
            'no' => $i + 1,
            'id' => $row['id'],
            'merk' => $row['merk'],
            'model' => $row['model'],
            'tahun' => $row['tahun'],
            'harga' => 'Rp ' . number_format($row['harga'], 0, ',', '.'),
            'warna' => $row['warna'],
            'transmisi' => $row['transmisi'],
            'km_tempuh' => number_format($row['km_tempuh'], 0, ',', '.') . ' km',
            'status' => $row['status'],
            'nama_penjual' => $row['nama_penjual'] ?? '-',
            'foto' => $row['foto'] ?? null,
        ];
    }, $data, array_keys($data));

    return $this->response->setJSON(['data' => $result]);
}
    // Halaman form tambah
    public function create() {
        $data['penjual'] = $this->penjualModel->findAll();
        return view('mobil/create', $data);
    }

    // Proses simpan data baru
    public function store() {
        $foto = $this->request->getFile('foto');
        $namaFoto = null;

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads', $namaFoto);
        }

        $this->mobilModel->insert([
            'penjual_id'  => $this->request->getPost('penjual_id'),
            'merk'        => $this->request->getPost('merk'),
            'model'       => $this->request->getPost('model'),
            'tahun'       => $this->request->getPost('tahun'),
            'harga'       => $this->request->getPost('harga'),
            'warna'       => $this->request->getPost('warna'),
            'transmisi'   => $this->request->getPost('transmisi'),
            'bahan_bakar' => $this->request->getPost('bahan_bakar'),
            'km_tempuh'   => $this->request->getPost('km_tempuh'),
            'status'      => $this->request->getPost('status'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto'        => $namaFoto,
        ]);

        session()->setFlashdata('success', 'Data mobil berhasil ditambahkan!');
        return redirect()->to('/mobil');
    }

    // Halaman form edit
    public function edit($id) {
        $data['mobil']   = $this->mobilModel->find($id);
        $data['penjual'] = $this->penjualModel->findAll();
        return view('mobil/edit', $data);
    }

    // Proses update
    public function update($id) {
        $foto = $this->request->getFile('foto');
        $mobil = $this->mobilModel->find($id);
        $namaFoto = $mobil['foto'];

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            // Hapus foto lama
            if ($namaFoto && file_exists(ROOTPATH . 'public/uploads/' . $namaFoto)) {
                unlink(ROOTPATH . 'public/uploads/' . $namaFoto);
            }
            $namaFoto = $foto->getRandomName();
            $foto->move(ROOTPATH . 'public/uploads', $namaFoto);
        }

        $this->mobilModel->update($id, [
            'penjual_id'  => $this->request->getPost('penjual_id'),
            'merk'        => $this->request->getPost('merk'),
            'model'       => $this->request->getPost('model'),
            'tahun'       => $this->request->getPost('tahun'),
            'harga'       => $this->request->getPost('harga'),
            'warna'       => $this->request->getPost('warna'),
            'transmisi'   => $this->request->getPost('transmisi'),
            'bahan_bakar' => $this->request->getPost('bahan_bakar'),
            'km_tempuh'   => $this->request->getPost('km_tempuh'),
            'status'      => $this->request->getPost('status'),
            'deskripsi'   => $this->request->getPost('deskripsi'),
            'foto'        => $namaFoto,
        ]);

        session()->setFlashdata('success', 'Data mobil berhasil diperbarui!');
        return redirect()->to('/mobil');
    }

    // Hapus data
    public function delete($id) {
        $mobil = $this->mobilModel->find($id);
        if ($mobil['foto'] && file_exists(ROOTPATH . 'public/uploads/' . $mobil['foto'])) {
            unlink(ROOTPATH . 'public/uploads/' . $mobil['foto']);
        }
        $this->mobilModel->delete($id);
        session()->setFlashdata('success', 'Data mobil berhasil dihapus!');
        return redirect()->to('/mobil');
    }
}