<?php

namespace App\Models;

class ProductsModel
{
    private $file = WRITEPATH . 'data/products.json';

    public function getProducts()
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $json = file_get_contents($this->file);
        $data = json_decode($json, true);

        return $data ? $data : [];
    }

    public function getProduct($id)
    {
        $products = $this->getProducts();

        foreach ($products as $product) {
            if ($product['id'] === $id) {
                return $product;
            }
        }

        return null;
    }

    public function insert($data)
    {
        $products = $this->getProducts();

        $data['id'] = uniqid();
        $products[] = $data;

        file_put_contents($this->file, json_encode($products, JSON_PRETTY_PRINT));
    }

    public function update($id, $newData)
    {
        $products = $this->getProducts();

        foreach ($products as $index => $product) {
            if ($product['id'] === $id) {
                $newData['id'] = $id;

                $products[$index] = array_merge($product, $newData);
                break;
            }
        }

        file_put_contents($this->file, json_encode($products, JSON_PRETTY_PRINT));
    }


    public function delete($id)
    {
        $products = $this->getProducts();

        $products = array_filter($products, function ($product) use ($id) {
            return $product['id'] !== $id;
        });

        $products = array_values($products);

        file_put_contents($this->file, json_encode($products, JSON_PRETTY_PRINT));
    }
}
