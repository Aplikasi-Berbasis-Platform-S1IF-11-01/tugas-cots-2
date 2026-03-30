<?php
namespace App\Controllers;
use App\Models\PenjualModel;

class PenjualController extends BaseController {
    protected $penjualModel;

    public function __construct() {
        $this->penjualModel = new PenjualModel();
    }

    public function index() {
        $data['penjual'] = $this->penjualModel->findAll();
        return view('penjual/index', $data);
    }

    public function create() {
        return view('penjual/create');
    }

    public function store() {
        $this->penjualModel->insert([
            'nama'    => $this->request->getPost('nama'),
            'telepon' => $this->request->getPost('telepon'),
            'email'   => $this->request->getPost('email'),
            'alamat'  => $this->request->getPost('alamat'),
        ]);
        session()->setFlashdata('success', 'Data penjual berhasil ditambahkan!');
        return redirect()->to('/penjual');
    }

    public function delete($id)
{
    $this->penjualModel->delete($id);

    session()->setFlashdata('success', 'Data penjual berhasil dihapus!');
    return redirect()->to('/penjual');
}

public function edit($id)
{
    $data['penjual'] = $this->penjualModel->find($id);
    return view('penjual/edit', $data);
}

public function update($id)
{
    $this->penjualModel->update($id, [
        'nama'    => $this->request->getPost('nama'),
        'telepon' => $this->request->getPost('telepon'),
        'email'   => $this->request->getPost('email'),
        'alamat'  => $this->request->getPost('alamat'),
    ]);

    session()->setFlashdata('success', 'Data penjual berhasil diupdate!');
    return redirect()->to('/penjual');
}

    public function getJson()
{
    $data = $this->penjualModel->findAll();

    $result = [];
    foreach ($data as $i => $p) {
        $result[] = [
            'id' => $p['id'], 
            'no' => $i + 1,
            'nama' => $p['nama'],
            'telepon' => $p['telepon'],
            'email' => $p['email'],
            'alamat' => $p['alamat']
        ];
    }

    return $this->response->setJSON(['data' => $result]);
}
}