<?php

namespace App\Modules\Auth\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'pengguna';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'peran_id',
        'opd_id',
        'nama_pengguna',
        'hash_kata_sandi',
        'alamat_surel',
        'status',
        'login_terakhir_pada',
        'dibuat_pada',
        'diperbarui_pada',
        'dihapus_pada',
    ];

    protected $useTimestamps = false;

    public function findByUsername(string $username)
    {
        return $this->where('nama_pengguna', $username)
                    ->where('status', 'AKTIF')
                    ->first();
    }

    public function getWithPeran(int $id)
    {
        return $this->select('pengguna.*, peran.kode as peran_kode, peran.nama as peran_nama')
                    ->join('peran', 'peran.id = pengguna.peran_id')
                    ->where('pengguna.id', $id)
                    ->first();
    }
}