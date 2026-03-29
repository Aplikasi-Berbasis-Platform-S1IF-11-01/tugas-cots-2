<?php

namespace App\Controllers;

use App\Models\TwsModel;

class Tws extends BaseController
{
    private $twsModel;

    public function __construct()
    {
        $this->twsModel = new TwsModel();
    }

    public function index()
    {
        return view('view_table');
    }

    public function create()
    {
        return view('create');
    }

    public function edit($id)
    {
        $tws = $this->twsModel->getById($id);
        if (!$tws) {
            return redirect()->to('/tws')->with('error', 'Data TWS tidak ditemukan');
        }
        return view('edit', ['tws' => $tws]);
    }

    public function save()
    {
        $id = $this->request->getPost('id');
        $name = $this->request->getPost('name');
        $brand = $this->request->getPost('brand');
        $price = (int) $this->request->getPost('price');
        $battery = $this->request->getPost('battery');

        if (empty($name) || empty($brand) || $price <= 0) {
            return redirect()->back()->withInput()->with('error', 'Nama, merek wajib diisi dan harga > 0');
        }

        $data = [
            'name'    => $name,
            'brand'   => $brand,
            'price'   => $price,
            'battery' => $battery ?: '-'
        ];

        if ($id) {
            $this->twsModel->update($id, $data);
            session()->setFlashdata('success', 'TWS berhasil diupdate');
        } else {
            $this->twsModel->insert($data);
            session()->setFlashdata('success', 'TWS berhasil ditambahkan');
        }

        return redirect()->to('/tws');
    }

    public function delete($id)
    {
        $this->twsModel->delete($id);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function json()
    {
        $items = $this->twsModel->getAll();
        return $this->response->setJSON($items);
    }
}