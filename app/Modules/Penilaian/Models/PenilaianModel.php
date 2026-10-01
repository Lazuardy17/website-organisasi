<?php

namespace App\Modules\Penilaian\Models;

use CodeIgniter\Model;

class PenilaianModel extends Model
{
    protected $table            = 'penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'opd_id',
        'periode_id',
        'status',
        'total_skor',
        'kesimpulan',
        'diajukan_pada',
        'diverifikasi_pada',
        'dibuat_oleh',
        'diperbarui_oleh',
        'dibuat_pada',
        'diperbarui_pada',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil periode yang sedang aktif (status TERBUKA).
     */
    public function getPeriodeAktif()
    {
        $db = \Config\Database::connect();
        return $db->table('periode_penilaian')
            ->where('status', 'TERBUKA')
            ->orderBy('tahun', 'DESC')
            ->get()->getRowArray();
    }

    /**
     * Ambil atau buat penilaian untuk OPD tertentu pada periode tertentu.
     * Kalau belum ada, buat baru dengan status DRAFT.
     */
    public function getOrCreate(int $opdId, int $periodeId, int $userId)
    {
        $existing = $this->where('opd_id', $opdId)
            ->where('periode_id', $periodeId)
            ->first();

        if ($existing) {
            return $existing;
        }

        $this->insert([
            'opd_id'       => $opdId,
            'periode_id'   => $periodeId,
            'status'       => 'DRAFT',
            'dibuat_oleh'  => $userId,
            'dibuat_pada'  => date('Y-m-d H:i:s'),
        ]);

        return $this->find($this->getInsertID());
    }
}