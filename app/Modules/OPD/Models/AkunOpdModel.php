<?php

namespace App\Modules\OPD\Models;

use CodeIgniter\Model;

class AkunOpdModel extends Model
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

    /**
     * Ambil semua akun User OPD (peran_id = 2) beserta data OPD-nya.
     */
    public function getAllWithOpd()
    {
        return $this->select('pengguna.*, perangkat_daerah.nama as nama_opd, perangkat_daerah.kode as kode_opd, perangkat_daerah.nama_kepala')
                    ->join('perangkat_daerah', 'perangkat_daerah.id = pengguna.opd_id', 'left')
                    ->where('pengguna.peran_id', 2)
                    ->orderBy('perangkat_daerah.nama', 'ASC')
                    ->findAll();
    }

    /**
     * Cek apakah OPD sudah punya akun.
     */
    public function cekOpdSudahPunyaAkun(int $opdId)
    {
        return $this->where('opd_id', $opdId)->first();
    }
}