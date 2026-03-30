<?php
namespace App\Models;
use CodeIgniter\Model;

class PenjualModel extends Model {
    protected $table = 'penjual';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'telepon', 'email', 'alamat'];
}