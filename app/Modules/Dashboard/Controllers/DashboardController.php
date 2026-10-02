<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function admin()
    {
        $db = \Config\Database::connect();

        $totalOpd = $db->table('perangkat_daerah')->where('status', 'AKTIF')->countAllResults();
        $belumSubmit = $db->table('penilaian')->where('status', 'DRAFT')->countAllResults();
        $menungguVerifikasi = $db->table('penilaian')
            ->whereIn('status', ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG'])
            ->countAllResults();
        $terverifikasi = $db->table('penilaian')->where('status', 'TERVERIFIKASI')->countAllResults();

        $antrean = $db->table('penilaian')
            ->select('penilaian.*, perangkat_daerah.nama as nama_opd, perangkat_daerah.kode as kode_opd')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->whereIn('penilaian.status', ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG'])
            ->orderBy('penilaian.diajukan_pada', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'          => 'Dashboard Admin',
            'total_opd'      => $totalOpd,
            'belum_submit'   => $belumSubmit,
            'menunggu_verif' => $menungguVerifikasi,
            'terverifikasi'  => $terverifikasi,
            'antrean'        => $antrean,
        ];

        return view('App\Modules\Dashboard\Views\admin', $data);
    }

    public function opd()
    {
        $opdId  = session()->get('opd_id');
        $userId = session()->get('user_id');

        $db = \Config\Database::connect();

        // Cek identitas lengkap
        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();
        if ($opd && empty($opd['identitas_lengkap'])) {
            return redirect()->to('/opd/identitas')->with('error', 'Lengkapi identitas terlebih dahulu.');
        }

        // Ambil periode aktif
        $periode = $db->table('periode_penilaian')
            ->where('status', 'TERBUKA')
            ->orderBy('tahun', 'DESC')
            ->get()->getRowArray();

        $totalVariabel   = 11;
        $terisi          = 0;
        $belumDiisi      = 11;
        $statusPenilaian = 'BELUM MULAI';
        $skor            = null;
        $catatanAdmin    = [];

        if ($periode) {
            // Ambil penilaian OPD ini
            $penilaian = $db->table('penilaian')
                ->where('opd_id', $opdId)
                ->where('periode_id', $periode['id'])
                ->get()->getRowArray();

            if ($penilaian) {
                $statusPenilaian = $penilaian['status'];

                // Hitung variabel terisi
                $terisi = $db->table('detail_penilaian')
                    ->where('penilaian_id', $penilaian['id'])
                    ->countAllResults();

                $belumDiisi = $totalVariabel - $terisi;

                // Kalau lengkap, tampilkan skor
                if ($terisi >= 11) {
                    $skor = $penilaian['total_skor'];
                }

                // Ambil catatan revisi (kalau ada)
                $catatanAdmin = $db->table('catatan_revisi')
                    ->whereIn('verifikasi_id', function ($builder) use ($penilaian) {
                        return $builder->select('id')->from('verifikasi_penilaian')
                                       ->where('penilaian_id', $penilaian['id']);
                    })
                    ->where('status', 'TERBUKA')
                    ->orderBy('dibuat_pada', 'DESC')
                    ->get()->getResultArray();
            }
        }

        $data = [
            'title'           => 'Dashboard OPD',
            'opd'             => $opd,
            'periode'         => $periode,
            'total_variabel'  => $totalVariabel,
            'terisi'          => $terisi,
            'belum_diisi'     => $belumDiisi,
            'status'          => $statusPenilaian,
            'skor'            => $skor,
            'catatan_admin'   => $catatanAdmin,
        ];

        return view('App\Modules\Dashboard\Views\user', $data);
    }
}