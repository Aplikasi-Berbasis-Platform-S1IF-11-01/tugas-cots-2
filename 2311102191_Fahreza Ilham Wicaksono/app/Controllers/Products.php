<?php

namespace App\Controllers;

use App\Models\ProductsModel;
use Config\Services;

class Products extends BaseController
{
    protected $productsModel;

    public function __construct()
    {
        $this->productsModel = new ProductsModel();
    }

    public function index(): string
    {
        $data = [
            'title' => 'Inventory'
        ];

        return view('products/index', $data);
    }

    public function create(): string
    {
        $data = [
            'title' => 'Add Product',
            'validation' => session('validation') ?? Services::validation()
        ];

        return view('products/create', $data);
    }

    public function store()
    {
        $rules = [
            'product_name' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            $data = [
                'title' => 'Add Product',
                'validation' => $this->validator
            ];

            return view('products/create', $data);
        }

        $this->productsModel->insert([
            'product_name' => $this->request->getPost('product_name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
        ]);

        session()->setFlashdata('message', 'Product successfully saved');

        return redirect()->to(base_url('/'));
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Product',
            'validation' => session('validation') ?? Services::validation(),
            'product' => $this->productsModel->getProduct($id)
        ];

        return view('products/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'product_name' => 'required|string',
            'category' => 'required|string',
            'price' => 'required|integer',
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/edit/' . $id)->withInput()->with('validation', $this->validator);
        }

        $this->productsModel->update($id, [
            'product_name' => $this->request->getPost('product_name'),
            'category' => $this->request->getPost('category'),
            'price' => $this->request->getPost('price'),
        ]);

        session()->setFlashdata('message', 'Data successfully updated');

        return redirect()->to(base_url('/'));
    }

    public function destroy($id)
    {
        $this->productsModel->delete($id);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Product successfully deleted'
        ]);
    }

    public function getProducts()
    {
        return $this->response->setJSON($this->productsModel->getProducts());
    }
}
