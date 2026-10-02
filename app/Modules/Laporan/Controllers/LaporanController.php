<?php

namespace App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends BaseController
{
    /**
     * Halaman pilih periode & OPD untuk ekspor.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil daftar periode
        $periodeList = $db->table('periode_penilaian')
            ->orderBy('tahun', 'DESC')
            ->get()->getResultArray();

        // Ambil daftar OPD yang sudah punya penilaian
        $opdList = $db->table('penilaian')
            ->select('perangkat_daerah.id, perangkat_daerah.nama, penilaian.status, penilaian.total_skor')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->orderBy('perangkat_daerah.nama', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title'       => 'Ekspor Laporan',
            'periodeList' => $periodeList,
            'opdList'     => $opdList,
        ];

        return view('App\Modules\Laporan\Views\index', $data);
    }

    /**
     * Generate PDF untuk satu OPD atau semua OPD.
     */
    public function generate()
    {
        $periodeId = (int) $this->request->getPost('periode_id');
        $opdId     = $this->request->getPost('opd_id'); // 'semua' atau ID OPD

        if (!$periodeId) {
            return redirect()->back()->with('error', 'Pilih periode terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        // Ambil info periode
        $periode = $db->table('periode_penilaian')->where('id', $periodeId)->get()->getRowArray();
        if (!$periode) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        // Query penilaian
        $builder = $db->table('penilaian')
            ->select('penilaian.*, 
                      perangkat_daerah.nama as nama_opd, 
                      perangkat_daerah.kode as kode_opd,
                      perangkat_daerah.nama_kepala,
                      perangkat_daerah.nip_kepala,
                      perangkat_daerah.pangkat_kepala')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->where('penilaian.periode_id', $periodeId);

        if ($opdId && $opdId !== 'semua') {
            $builder->where('penilaian.opd_id', (int) $opdId);
        }

        $penilaianList = $builder->orderBy('perangkat_daerah.nama', 'ASC')
                                 ->get()->getResultArray();

        if (empty($penilaianList)) {
            return redirect()->back()->with('error', 'Tidak ada data untuk filter yang dipilih.');
        }

        // Untuk setiap penilaian, ambil detail 11 variabel
        foreach ($penilaianList as &$p) {
            $p['detail'] = $db->table('detail_penilaian')
                ->select('detail_penilaian.*, 
                          variabel_penilaian.nama as nama_variabel, 
                          variabel_penilaian.nomor_urutan,
                          tingkat_penilaian.nama_tingkat,
                          tingkat_penilaian.nomor_tingkat')
                ->join('variabel_penilaian', 'variabel_penilaian.id = detail_penilaian.variabel_id')
                ->join('tingkat_penilaian', 'tingkat_penilaian.id = detail_penilaian.tingkat_id')
                ->where('detail_penilaian.penilaian_id', $p['id'])
                ->orderBy('variabel_penilaian.nomor_urutan', 'ASC')
                ->get()->getResultArray();
        }
        unset($p);

        // Render HTML dari view
        $html = view('App\Modules\Laporan\Views\pdf', [
            'periode'       => $periode,
            'penilaianList' => $penilaianList,
        ]);

        // Konfigurasi Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Nama file
        $namaFile = 'laporan-penilaian-' . $periode['tahun'];
        if ($opdId && $opdId !== 'semua') {
            $namaFile .= '-opd-' . $opdId;
        }
        $namaFile .= '.pdf';

        // Output ke browser (download)
        $dompdf->stream($namaFile, ['Attachment' => true]);
        exit;
    }
}