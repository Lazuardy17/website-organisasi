<?php

namespace App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanOpdController extends BaseController
{
    /**
     * Halaman pilih periode & format ekspor untuk User OPD.
     */
    public function index()
    {
        $opdId = session()->get('opd_id');
        $db    = \Config\Database::connect();

        // Ambil info OPD
        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();
        if (!$opd) {
            return redirect()->to('/opd/dashboard')->with('error', 'Data OPD tidak ditemukan.');
        }

        // Ambil semua periode
        $periodeList = $db->table('periode_penilaian')
            ->orderBy('tahun', 'DESC')
            ->get()->getResultArray();

        // Untuk setiap periode, cek status penilaian OPD ini
        foreach ($periodeList as &$p) {
            $penilaian = $db->table('penilaian')
                ->where('opd_id', $opdId)
                ->where('periode_id', $p['id'])
                ->get()->getRowArray();

            $p['status']    = $penilaian['status'] ?? null;
            $p['total_skor'] = $penilaian['total_skor'] ?? null;
            $p['kesimpulan'] = $penilaian['kesimpulan'] ?? null;
            $p['bisa_cetak'] = ($p['status'] === 'TERVERIFIKASI');
        }
        unset($p);

        // Ambil preview 11 variabel + skor dari periode default (yang TERVERIFIKASI terbaru)
        $preview = [];
        $periodePreview = null;
        foreach ($periodeList as $p) {
            if ($p['bisa_cetak']) {
                $periodePreview = $p;
                break;
            }
        }

        if ($periodePreview) {
            $penilaian = $db->table('penilaian')
                ->where('opd_id', $opdId)
                ->where('periode_id', $periodePreview['id'])
                ->get()->getRowArray();

            if ($penilaian) {
                $preview = $db->table('detail_penilaian')
                    ->select('detail_penilaian.*, 
                              variabel_penilaian.nama as nama_variabel, 
                              variabel_penilaian.nomor_urutan,
                              tingkat_penilaian.nama_tingkat')
                    ->join('variabel_penilaian', 'variabel_penilaian.id = detail_penilaian.variabel_id')
                    ->join('tingkat_penilaian', 'tingkat_penilaian.id = detail_penilaian.tingkat_id')
                    ->where('detail_penilaian.penilaian_id', $penilaian['id'])
                    ->orderBy('variabel_penilaian.nomor_urutan', 'ASC')
                    ->get()->getResultArray();
            }
        }

        $data = [
            'title'          => 'Ekspor Laporan',
            'opd'            => $opd,
            'periodeList'    => $periodeList,
            'periodePreview' => $periodePreview,
            'preview'        => $preview,
        ];

        return view('App\Modules\Laporan\Views\opd_index', $data);
    }

    /**
     * Generate PDF untuk OPD ini.
     */
    public function generate()
    {
        $opdId     = session()->get('opd_id');
        $periodeId = (int) $this->request->getPost('periode_id');
        $format    = $this->request->getPost('format'); // 'sheet4' | 'sheet5' | 'gabungan'

        if (!$periodeId) {
            return redirect()->back()->with('error', 'Pilih periode terlebih dahulu.');
        }

        if (!in_array($format, ['sheet4', 'sheet5', 'gabungan'])) {
            return redirect()->back()->with('error', 'Pilih format laporan.');
        }

        $db = \Config\Database::connect();

        // Ambil info OPD
        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();
        if (!$opd) {
            return redirect()->back()->with('error', 'Data OPD tidak ditemukan.');
        }

        // Ambil info periode
        $periode = $db->table('periode_penilaian')->where('id', $periodeId)->get()->getRowArray();
        if (!$periode) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        // Ambil penilaian OPD
        $penilaian = $db->table('penilaian')
            ->where('opd_id', $opdId)
            ->where('periode_id', $periodeId)
            ->get()->getRowArray();

        if (!$penilaian || $penilaian['status'] !== 'TERVERIFIKASI') {
            return redirect()->back()->with('error', 'Laporan hanya bisa dicetak setelah diverifikasi Admin.');
        }

        // Ambil detail 11 variabel + bukti
        $detail = $db->table('detail_penilaian')
            ->select('detail_penilaian.*, 
                      variabel_penilaian.nama as nama_variabel, 
                      variabel_penilaian.nomor_urutan,
                      tingkat_penilaian.nama_tingkat,
                      tingkat_penilaian.nomor_tingkat,
                      tingkat_penilaian.indikator,
                      tingkat_penilaian.verifikasi_bukti')
            ->join('variabel_penilaian', 'variabel_penilaian.id = detail_penilaian.variabel_id')
            ->join('tingkat_penilaian', 'tingkat_penilaian.id = detail_penilaian.tingkat_id')
            ->where('detail_penilaian.penilaian_id', $penilaian['id'])
            ->orderBy('variabel_penilaian.nomor_urutan', 'ASC')
            ->get()->getResultArray();

        // Untuk setiap detail, ambil link bukti
        foreach ($detail as &$d) {
            $bukti = $db->table('bukti_penilaian')
                ->where('detail_id', $d['id'])
                ->get()->getRowArray();
            $d['tautan_bukti'] = $bukti['tautan'] ?? '';
        }
        unset($d);

        // Ambil 5 tingkat untuk setiap variabel (untuk Sheet 5)
        $variabelList = $db->table('variabel_penilaian')
            ->where('aktif', true)
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        foreach ($variabelList as &$v) {
            $v['tingkat'] = $db->table('tingkat_penilaian')
                ->where('variabel_id', $v['id'])
                ->where('aktif', true)
                ->orderBy('nomor_tingkat', 'ASC')
                ->get()->getResultArray();

            // Cari detail untuk variabel ini
            $detailVariabel = null;
            foreach ($detail as $d) {
                if ($d['variabel_id'] == $v['id']) {
                    $detailVariabel = $d;
                    break;
                }
            }
            $v['detail'] = $detailVariabel;
        }
        unset($v);

        // Render HTML dari view
        $html = view('App\Modules\Laporan\Views\opd_pdf', [
            'opd'          => $opd,
            'periode'      => $periode,
            'penilaian'    => $penilaian,
            'detail'       => $detail,
            'variabelList' => $variabelList,
            'format'       => $format,
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
        $namaFile = 'laporan-' . strtolower($opd['kode']) . '-' . $periode['tahun'] . '.pdf';

        // Output ke browser (download)
        $dompdf->stream($namaFile, ['Attachment' => true]);
        exit;
    }
}