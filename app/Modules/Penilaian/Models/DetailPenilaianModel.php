<?php

namespace App\Modules\Penilaian\Models;

use CodeIgniter\Model;

class DetailPenilaianModel extends Model
{
    protected $table            = 'detail_penilaian';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'penilaian_id',
        'variabel_id',
        'tingkat_id',
        'nilai_skor',
        'dilisi_oleh',
        'dilisi_pada',
        'dibuat_pada',
        'diperbarui_pada',
    ];

    protected $useTimestamps = false;

    /**
     * Ambil semua detail untuk penilaian tertentu,
     * beserta info variabel dan tingkat (join).
     */
    public function getByPenilaian(int $penilaianId)
    {
        return $this->select('detail_penilaian.*, 
                              variabel_penilaian.nama as nama_variabel, 
                              variabel_penilaian.nomor_urutan,
                              tingkat_penilaian.nama_tingkat,
                              tingkat_penilaian.nomor_tingkat,
                              tingkat_penilaian.indikator,
                              tingkat_penilaian.verifikasi_bukti')
            ->join('variabel_penilaian', 'variabel_penilaian.id = detail_penilaian.variabel_id')
            ->join('tingkat_penilaian', 'tingkat_penilaian.id = detail_penilaian.tingkat_id')
            ->where('detail_penilaian.penilaian_id', $penilaianId)
            ->orderBy('variabel_penilaian.nomor_urutan', 'ASC')
            ->findAll();
    }

    /**
     * Ambil detail untuk satu variabel dalam penilaian tertentu.
     * Return null kalau belum diisi.
     */
    public function getByPenilaianAndVariabel(int $penilaianId, int $variabelId)
    {
        return $this->where('penilaian_id', $penilaianId)
            ->where('variabel_id', $variabelId)
            ->first();
    }

    /**
     * Hitung total skor dari semua detail penilaian.
     */
    public function hitungTotalSkor(int $penilaianId)
    {
        $result = $this->selectSum('nilai_skor')
            ->where('penilaian_id', $penilaianId)
            ->first();

        return $result['nilai_skor'] ?? 0;
    }

    /**
     * Hitung jumlah variabel yang sudah diisi.
     */
    public function hitungVariabelTerisi(int $penilaianId)
    {
        return $this->where('penilaian_id', $penilaianId)->countAllResults();
    }
}