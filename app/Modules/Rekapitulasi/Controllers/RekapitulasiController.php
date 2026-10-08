<?php

namespace App\Modules\Rekapitulasi\Controllers;

use App\Controllers\BaseController;
use App\Modules\Penilaian\Models\PenilaianModel;

class RekapitulasiController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil parameter filter
        $periodeId = $this->request->getGet('periode_id');
        $status    = $this->request->getGet('status');

        // Ambil daftar periode untuk dropdown
        $periodeList = $db->table('periode_penilaian')
            ->orderBy('tahun', 'DESC')
            ->get()->getResultArray();

        // Kalau belum pilih periode, pakai periode aktif (TERBUKA)
        if (!$periodeId && !empty($periodeList)) {
            $aktif = $db->table('periode_penilaian')
                ->where('status', 'TERBUKA')
                ->orderBy('tahun', 'DESC')
                ->get()->getRowArray();
            $periodeId = $aktif ? $aktif['id'] : $periodeList[0]['id'];
        }

        // Filter periode & status, dipakai oleh tabel DAN statistik
        $terapkanFilter = function ($query) use ($periodeId, $status) {
            if ($periodeId) {
                $query->where('penilaian.periode_id', $periodeId);
            }
            if ($status && $status !== 'semua') {
                $query->where('penilaian.status', $status);
            }
            return $query;
        };

        // Tabel: 10 baris per halaman (paginate() membaca ?page= dari URL;
        // filter periode_id & status ikut terbawa di link pagination)
        $model = new PenilaianModel();
        $model->select('penilaian.*, 
                        perangkat_daerah.nama as nama_opd, 
                        perangkat_daerah.kode as kode_opd,
                        perangkat_daerah.nama_kepala,
                        periode_penilaian.tahun as tahun_periode')
              ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
              ->join('periode_penilaian', 'periode_penilaian.id = penilaian.periode_id', 'left');

        $daftar = $terapkanFilter($model)
            ->orderBy('perangkat_daerah.id', 'ASC')
            ->orderBy('penilaian.id', 'ASC')   // urutan kedua agar halaman stabil
            ->paginate(10);

        // Statistik ringkasan: dihitung dari SELURUH data yang lolos filter,
        // bukan hanya 10 baris di halaman ini.
        $stat = $terapkanFilter($db->table('penilaian'))
            ->select("COUNT(*) AS total,
                      SUM(CASE WHEN penilaian.status = 'TERVERIFIKASI' THEN 1 ELSE 0 END) AS terverifikasi,
                      SUM(CASE WHEN penilaian.status IN ('DIKIRIM', 'PERLU_VERIFIKASI_ULANG') THEN 1 ELSE 0 END) AS menunggu,
                      SUM(CASE WHEN penilaian.total_skor > 0 THEN penilaian.total_skor ELSE 0 END) AS jumlah_skor,
                      SUM(CASE WHEN penilaian.total_skor > 0 THEN 1 ELSE 0 END) AS jumlah_ada_skor", false)
            ->get()->getRowArray();

        $totalDinilai        = (int) ($stat['total'] ?? 0);
        $jumlahTerverifikasi = (int) ($stat['terverifikasi'] ?? 0);
        $jumlahMenunggu      = (int) ($stat['menunggu'] ?? 0);
        $totalSkor           = (float) ($stat['jumlah_skor'] ?? 0);
        $jumlahAdaSkor       = (int) ($stat['jumlah_ada_skor'] ?? 0);

        $rataRataSkor = ($jumlahAdaSkor > 0) ? ($totalSkor / $jumlahAdaSkor) : 0;

        $data = [
            'title'              => 'Rekapitulasi Data',
            'daftar'             => $daftar,
            'pager'              => $model->pager,
            'periodeList'        => $periodeList,
            'periodeId'          => $periodeId,
            'statusFilter'       => $status ?: 'semua',
            'totalDinilai'       => $totalDinilai,
            'jumlahTerverifikasi' => $jumlahTerverifikasi,
            'jumlahMenunggu'     => $jumlahMenunggu,
            'rataRataSkor'       => $rataRataSkor,
        ];

        return view('App\Modules\Rekapitulasi\Views\index', $data);
    }
}