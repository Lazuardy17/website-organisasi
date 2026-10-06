<?php

namespace App\Modules\Rekapitulasi\Controllers;

use App\Controllers\BaseController;

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

        // Query dasar: semua penilaian
        $builder = $db->table('penilaian')
            ->select('penilaian.*, 
                      perangkat_daerah.nama as nama_opd, 
                      perangkat_daerah.kode as kode_opd,
                      perangkat_daerah.nama_kepala,
                      periode_penilaian.tahun as tahun_periode')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->join('periode_penilaian', 'periode_penilaian.id = penilaian.periode_id', 'left');

        // Filter periode
        if ($periodeId) {
            $builder->where('penilaian.periode_id', $periodeId);
        }

        // Filter status
        if ($status && $status !== 'semua') {
            $builder->where('penilaian.status', $status);
        }

        $daftar = $builder->orderBy('perangkat_daerah.id', 'ASC')
                          ->get()->getResultArray();

        // Statistik ringkasan
        $totalDinilai        = count($daftar);
        $jumlahTerverifikasi = 0;
        $jumlahMenunggu      = 0;
        $totalSkor           = 0;
        $jumlahAdaSkor       = 0;

        foreach ($daftar as $d) {
            if ($d['status'] === 'TERVERIFIKASI') $jumlahTerverifikasi++;
            if (in_array($d['status'], ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG'])) $jumlahMenunggu++;
            if ($d['total_skor'] > 0) {
                $totalSkor += (float) $d['total_skor'];
                $jumlahAdaSkor++;
            }
        }

        $rataRataSkor = ($jumlahAdaSkor > 0) ? ($totalSkor / $jumlahAdaSkor) : 0;

        $data = [
            'title'              => 'Rekapitulasi Data',
            'daftar'             => $daftar,
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