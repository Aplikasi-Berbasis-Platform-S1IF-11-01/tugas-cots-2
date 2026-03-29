<?php

namespace App\Controllers;

class Produk extends BaseController
{
    private $file = WRITEPATH . 'produk.json';

    private function readData()
    {
        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
        return json_decode(file_get_contents($this->file), true);
    }

    private function writeData($data)
    {
        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function form()
    {
        return view('form');
    }

    public function table()
    {
        return view('table');
    }

    public function edit($id)
    {
        $data = $this->readData();
        foreach ($data as $d) {
            if ($d['id'] == $id) {
                return view('edit', ['produk' => $d]);
            }
        }
    }

    // Json
    public function getData()
    {
        return $this->response->setJSON([
            "data" => $this->readData()
        ]);
    }

    // Create
    public function save()
    {
        $data = $this->readData();

        $data[] = [
            "id" => time(),
            "nama" => $this->request->getPost('nama'),
            "kategori" => $this->request->getPost('kategori'),
            "harga" => $this->request->getPost('harga')
        ];

        $this->writeData($data);

        return redirect()->to('/table');
    }

    // Update
    public function update($id)
    {
        $data = $this->readData();

        foreach ($data as &$d) {
            if ($d['id'] == $id) {
                $d['nama'] = $this->request->getPost('nama');
                $d['kategori'] = $this->request->getPost('kategori');
                $d['harga'] = $this->request->getPost('harga');
            }
        }

        $this->writeData($data);

        return redirect()->to('/table');
    }

    // Delete
    public function delete($id)
    {
        $data = $this->readData();

        $data = array_filter($data, fn($d) => $d['id'] != $id);

        $this->writeData(array_values($data));

        return redirect()->to('/table');
    }
}