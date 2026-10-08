<?php

namespace App\Modules\Laporan\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;
use Dompdf\Options;

class LaporanController extends BaseController
{
    /**
     * Halaman pilih periode & cakupan untuk Admin.
     */
    public function index()
    {
        $db = \Config\Database::connect();

        $periodeList = $db->table('periode_penilaian')
            ->orderBy('tahun', 'DESC')
            ->get()->getResultArray();

        // Ambil OPD yang punya penilaian (untuk dropdown)
        $opdList = $db->table('penilaian')
            ->select('perangkat_daerah.id, perangkat_daerah.nama')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->orderBy('perangkat_daerah.id', 'ASC')
            ->groupBy('perangkat_daerah.id')
            ->get()->getResultArray();

        $data = [
            'title'       => 'Ekspor Laporan',
            'periodeList' => $periodeList,
            'opdList'     => $opdList,
        ];

        return view('App\Modules\Laporan\Views\admin_index', $data);
    }

    /**
     * Generate PDF — tergantung cakupan.
     */
    public function generate()
    {
        $periodeId = (int) $this->request->getPost('periode_id');
        $opdId     = $this->request->getPost('opd_id');
        $format    = $this->request->getPost('format');

        if (!$periodeId) {
            return redirect()->back()->with('error', 'Pilih periode terlebih dahulu.');
        }

        $db = \Config\Database::connect();

        $periode = $db->table('periode_penilaian')->where('id', $periodeId)->get()->getRowArray();
        if (!$periode) {
            return redirect()->back()->with('error', 'Periode tidak ditemukan.');
        }

        // ======================== SEMUA OPD ========================
        if ($opdId === 'semua') {
            $penilaianList = $db->table('penilaian')
                ->select('penilaian.*, 
                          perangkat_daerah.nama as nama_opd,
                          perangkat_daerah.kode as kode_opd')
                ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
                ->where('penilaian.periode_id', $periodeId)
                ->where('penilaian.status', 'TERVERIFIKASI')
                ->orderBy('perangkat_daerah.id', 'ASC')
                ->get()->getResultArray();

            if (empty($penilaianList)) {
                return redirect()->back()->with('error', 'Belum ada OPD dengan status TERVERIFIKASI pada periode ini.');
            }

            $html = view('App\Modules\Laporan\Views\admin_pdf_semua', [
                'periode'       => $periode,
                'penilaianList' => $penilaianList,
            ]);

            $pdf = $this->renderPdf($html, 'portrait');
            $namaFile = 'laporan-semua-opd-' . $periode['tahun'] . '.pdf';

            return $this->response
                ->setHeader('Content-Type', 'application/pdf')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
                ->setBody($pdf);
        }

        // ======================== SATU OPD ========================
        $opdId = (int) $opdId;
        if (!$opdId) {
            return redirect()->back()->with('error', 'Pilih OPD terlebih dahulu.');
        }

        if (!in_array($format, ['sheet4', 'sheet5', 'gabungan'])) {
            return redirect()->back()->with('error', 'Pilih format laporan.');
        }

        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();
        if (!$opd) {
            return redirect()->back()->with('error', 'OPD tidak ditemukan.');
        }

        $penilaian = $db->table('penilaian')
            ->where('opd_id', $opdId)
            ->where('periode_id', $periodeId)
            ->get()->getRowArray();

        if (!$penilaian || $penilaian['status'] !== 'TERVERIFIKASI') {
            return redirect()->back()->with('error', 'OPD ini belum terverifikasi pada periode ini.');
        }

        // Ambil detail 11 variabel
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

        foreach ($detail as &$d) {
            $bukti = $db->table('bukti_penilaian')->where('detail_id', $d['id'])->get()->getRowArray();
            $d['tautan_bukti'] = $bukti['tautan'] ?? '';
        }
        unset($d);

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

        // Render sesuai format — pakai font kustom (sama dengan OPD)
        if ($format === 'sheet4') {
            $pdf = $this->renderOpdPdf('sheet4', $dataView);
        } elseif ($format === 'sheet5') {
            $pdf = $this->renderOpdPdf('sheet5', $dataView);
        } else {
            $pdf = $this->gabungkanPdf([
                $this->renderOpdPdf('sheet4', $dataView),
                $this->renderOpdPdf('sheet5', $dataView),
            ]);
        }

        $namaFile = 'laporan-' . strtolower($opd['kode']) . '-' . $periode['tahun'] . '.pdf';

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->setBody($pdf);
    }

    /* =========================================================
     * RENDER PDF — termasuk font kustom
     * ========================================================= */

    private function renderPdf(string $html, string $orientasi = 'portrait'): string
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

        $dompdf->loadHtml($html);
        $dompdf->setPaper('letter', $orientasi);
        $dompdf->render();

        return $dompdf->output();
    }

    private function renderOpdPdf(string $format, array $dataView): string
    {
        $html = view('App\Modules\Laporan\Views\opd_pdf', $dataView + ['format' => $format]);
        return $this->renderPdf($html, $format === 'sheet5' ? 'landscape' : 'portrait');
    }

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