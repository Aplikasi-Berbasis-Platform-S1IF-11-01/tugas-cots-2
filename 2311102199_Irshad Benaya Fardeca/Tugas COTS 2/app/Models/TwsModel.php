<?php

namespace App\Models;

class TwsModel
{
    private $filePath;

    public function __construct()
    {
        $this->filePath = WRITEPATH . 'data/tws.json';
        $this->initFile();
    }

    private function initFile()
    {
        $directory = dirname($this->filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        if (!file_exists($this->filePath)) {
            file_put_contents($this->filePath, json_encode([]));
        }
    }

    private function readData()
    {
        $data = file_get_contents($this->filePath);
        return json_decode($data, true) ?: [];
    }

    private function writeData($data)
    {
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }

    public function getAll()
    {
        return $this->readData();
    }

    public function getById($id)
    {
        $items = $this->readData();
        foreach ($items as $item) {
            if ($item['id'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public function insert($data)
    {
        $items = $this->readData();
        $data['id'] = time();
        $items[] = $data;
        $this->writeData($items);
        return $data['id'];
    }

    public function update($id, $data)
    {
        $items = $this->readData();
        foreach ($items as &$item) {
            if ($item['id'] == $id) {
                $item = array_merge($item, $data);
                $this->writeData($items);
                return true;
            }
        }
        return false;
    }

    public function delete($id)
    {
        $items = $this->readData();
        $newItems = array_filter($items, function ($item) use ($id) {
            return $item['id'] != $id;
        });
        $this->writeData(array_values($newItems));
        return true;
    }
}