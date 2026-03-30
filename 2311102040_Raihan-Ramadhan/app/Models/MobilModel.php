<?php
namespace App\Models;
use CodeIgniter\Model;

class MobilModel extends Model {
    protected $table = 'mobil';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'penjual_id', 'merk', 'model', 'tahun', 'harga',
        'warna', 'transmisi', 'bahan_bakar', 'km_tempuh',
        'status', 'deskripsi', 'foto'
    ];

    public function getMobilWithPenjual() {
        return $this->db->table('mobil m')
            ->select('m.*, p.nama as nama_penjual, p.telepon')
            ->join('penjual p', 'p.id = m.penjual_id', 'left')
            ->orderBy('m.created_at', 'DESC')
            ->limit(50) // 🔥 OPTIMASI
            ->get()
            ->getResultArray();
    }

    public function getMobilById($id) {
        return $this->db->table('mobil m')
            ->select('m.*, p.nama as nama_penjual, p.telepon, p.email')
            ->join('penjual p', 'p.id = m.penjual_id', 'left')
            ->where('m.id', $id)
            ->get()->getRowArray();
    }
}