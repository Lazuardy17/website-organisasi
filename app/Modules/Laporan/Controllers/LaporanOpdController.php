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

            $p['status']     = $penilaian['status'] ?? null;
            $p['total_skor'] = $penilaian['total_skor'] ?? null;
            $p['kesimpulan'] = $penilaian['kesimpulan'] ?? null;
            $p['bisa_cetak'] = ($p['status'] === 'TERVERIFIKASI');
        }
        unset($p);

        // Ambil preview 11 variabel + skor dari periode default (yang TERVERIFIKASI terbaru)
        $preview        = [];
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

        $dataView = [
            'opd'          => $opd,
            'periode'      => $periode,
            'penilaian'    => $penilaian,
            'detail'       => $detail,
            'variabelList' => $variabelList,
        ];

        // Sheet 4 = Letter portrait, Sheet 5 = Letter landscape.
        // Format gabungan = dua PDF dirender terpisah lalu digabung (Dompdf
        // tidak bisa mencampur orientasi dalam satu dokumen).
        if ($format === 'sheet4') {
            $pdf = $this->renderPdf('sheet4', $dataView);
        } elseif ($format === 'sheet5') {
            $pdf = $this->renderPdf('sheet5', $dataView);
        } else {
            $pdf = $this->gabungkanPdf([
                $this->renderPdf('sheet4', $dataView),
                $this->renderPdf('sheet5', $dataView),
            ]);
        }

        $namaFile = 'laporan-' . strtolower($opd['kode']) . '-' . $periode['tahun'] . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->setBody($pdf);
    }

    /**
     * Render satu view ke string PDF (Letter).
     */
    private function renderPdf(string $format, array $dataView): string
    {
        $fontDir = WRITEPATH . 'fonts';

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isFontSubsettingEnabled', true);
        $options->set('chroot', ROOTPATH);
        $options->set('fontDir', $fontDir);
        $options->set('fontCache', $fontDir);

        $dompdf = new Dompdf($options);
        $this->daftarkanFont($dompdf, $fontDir);

        $html = view('App\Modules\Laporan\Views\opd_pdf', $dataView + ['format' => $format]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', $format === 'sheet5' ? 'landscape' : 'portrait');
        $dompdf->render();

        return $dompdf->output();
    }

    /**
     * Daftarkan font Calibri & Bookman Old Style ke Dompdf (hanya sekali;
     * hasilnya disimpan di writable/fonts/installed-fonts.json).
     */
    private function daftarkanFont(Dompdf $dompdf, string $fontDir): void
    {
        $fm = $dompdf->getFontMetrics();

        $daftar = [
            ['XCalibri', 'normal', 'normal', 'calibri.ttf'],
            ['XCalibri', 'bold',   'normal', 'calibrib.ttf'],
            ['XBookman', 'normal', 'normal', 'bookos.ttf'],
            ['XBookman', 'bold',   'normal', 'bookosb.ttf'],
            ['XBookman', 'normal', 'italic', 'bookosi.ttf'],
            ['XBookman', 'bold',   'italic', 'bookosbi.ttf'],
        ];

        foreach ($daftar as [$family, $weight, $style, $file]) {
            $path = $fontDir . DIRECTORY_SEPARATOR . $file;
            if (!is_file($path)) {
                log_message('error', 'Font tidak ditemukan: ' . $path);
                continue;
            }

            // Lewati kalau varian ini sudah terdaftar
            $sudah = $fm->getFamily(strtolower($family));
            $key   = ($weight === 'bold' ? 'bold' : 'normal') . ($style === 'italic' ? '_italic' : '');
            if ($key === 'normal_italic') {
                $key = 'italic';
            }
            if (is_array($sudah) && isset($sudah[$key])) {
                continue;
            }

            $fm->registerFont(
                ['family' => $family, 'weight' => $weight, 'style' => $style],
                $path
            );
        }
    }

    /**
     * Gabungkan beberapa PDF (string) menjadi satu, ukuran & orientasi
     * tiap halaman dipertahankan. Butuh: composer require setasign/fpdi setasign/fpdf
     */
    private function gabungkanPdf(array $daftarPdf): string
    {
        $fpdi = new \setasign\Fpdi\Fpdi();
        $fpdi->SetAutoPageBreak(false);

        foreach ($daftarPdf as $pdfString) {
            $jumlah = $fpdi->setSourceFile(\setasign\Fpdi\PdfParser\StreamReader::createByString($pdfString));
            for ($n = 1; $n <= $jumlah; $n++) {
                $tpl  = $fpdi->importPage($n);
                $size = $fpdi->getTemplateSize($tpl);
                $fpdi->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $fpdi->useTemplate($tpl);
            }
        }

        return $fpdi->Output('S');
    }
}