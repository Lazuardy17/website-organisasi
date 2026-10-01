<?php

namespace App\Modules\Penilaian\Models;

use CodeIgniter\Model;

class BuktiPenilaianModel extends Model
{
    protected $table            = 'bukti_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'detail_id',
        'jenis_bukti',
        'judul',
        'tautan',
        'lokasi_berkas',
        'deskripsi',
        'diunggah_oleh',
        'dibuat_pada',
        'diperbarui_pada',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil bukti untuk satu detail penilaian.
     * Karena 1 detail bisa punya banyak bukti, ambil yang pertama saja.
     */
    public function getByDetail(int $detailId)
    {
        return $this->where('detail_id', $detailId)
            ->orderBy('id', 'ASC')
            ->first();
    }

    /**
     * Simpan atau update bukti untuk satu detail.
     * Kalau sudah ada, update. Kalau belum, insert.
     */
    public function simpanBukti(int $detailId, string $tautan, int $userId)
    {
        $existing = $this->where('detail_id', $detailId)->first();

        if ($existing) {
            $this->update($existing['id'], [
                'jenis_bukti'     => 'TAUTAN',
                'tautan'          => $tautan,
                'diunggah_oleh'   => $userId,
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ]);
            return $existing['id'];
        }

        $this->insert([
            'detail_id'      => $detailId,
            'jenis_bukti'    => 'TAUTAN',
            'tautan'         => $tautan,
            'diunggah_oleh'  => $userId,
            'dibuat_pada'    => date('Y-m-d H:i:s'),
        ]);
        return $this->getInsertID();
    }
}