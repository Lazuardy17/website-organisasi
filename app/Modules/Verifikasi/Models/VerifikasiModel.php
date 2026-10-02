<?php

namespace App\Modules\Verifikasi\Models;

use CodeIgniter\Model;

class VerifikasiModel extends Model
{
    protected $table            = 'verifikasi_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'penilaian_id',
        'pemeriksa_id',
        'nomor_siklus',
        'keputusan',
        'catatan',
        'diperiksa_pada',
    ];

    protected $useTimestamps = false;

    /**
     * Hitung nomor siklus berikutnya untuk penilaian tertentu.
     */
    public function getSiklusBerikutnya(int $penilaianId)
    {
        $last = $this->where('penilaian_id', $penilaianId)
            ->orderBy('nomor_siklus', 'DESC')
            ->first();

        return $last ? ((int) $last['nomor_siklus'] + 1) : 1;
    }

    /**
     * Ambil semua riwayat verifikasi untuk penilaian tertentu.
     */
    public function getByPenilaian(int $penilaianId)
    {
        return $this->select('verifikasi_penilaian.*, pengguna.nama_pengguna as nama_pemeriksa')
            ->join('pengguna', 'pengguna.id = verifikasi_penilaian.pemeriksa_id', 'left')
            ->where('verifikasi_penilaian.penilaian_id', $penilaianId)
            ->orderBy('verifikasi_penilaian.nomor_siklus', 'ASC')
            ->findAll();
    }

    /**
     * Ambil catatan revisi untuk detail tertentu.
     */
    public function getCatatanByDetail(int $detailId)
    {
        $db = \Config\Database::connect();
        return $db->table('catatan_revisi')
            ->where('detail_id', $detailId)
            ->where('status', 'TERBUKA')
            ->orderBy('dibuat_pada', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Simpan catatan revisi.
     */
    public function simpanCatatan(int $verifikasiId, ?int $detailId, string $catatan)
    {
        $db = \Config\Database::connect();
        return $db->table('catatan_revisi')->insert([
            'verifikasi_id' => $verifikasiId,
            'detail_id'     => $detailId,
            'catatan'       => $catatan,
            'status'        => 'TERBUKA',
            'dibuat_pada'   => date('Y-m-d H:i:s'),
        ]);
    }
}