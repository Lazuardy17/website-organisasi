<?php

namespace App\Modules\Penilaian\Controllers;

use App\Controllers\BaseController;
use App\Modules\Penilaian\Models\PenilaianModel;
use App\Modules\Penilaian\Models\DetailPenilaianModel;
use App\Modules\Penilaian\Models\BuktiPenilaianModel;

class PenilaianController extends BaseController
{
    protected $penilaianModel;
    protected $detailModel;
    protected $buktiModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->detailModel    = new DetailPenilaianModel();
        $this->buktiModel     = new BuktiPenilaianModel();
    }

    public function index()
    {
        $opdId  = session()->get('opd_id');
        $userId = session()->get('user_id');

        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/dashboard')->with('error', 'Tidak ada periode penilaian yang aktif.');
        }

        $penilaian = $this->penilaianModel->getOrCreate($opdId, $periode['id'], $userId);

        $db = \Config\Database::connect();
        $variabel = $db->table('variabel_penilaian')
            ->where('aktif', true)
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        foreach ($variabel as &$v) {
            $v['tingkat'] = $db->table('tingkat_penilaian')
                ->where('variabel_id', $v['id'])
                ->where('aktif', true)
                ->orderBy('nomor_tingkat', 'ASC')
                ->get()->getResultArray();

            $detail = $this->detailModel->getByPenilaianAndVariabel($penilaian['id'], $v['id']);
            if ($detail) {
                $v['tingkat_id_terpilih'] = $detail['tingkat_id'];
                $v['nilai_skor']          = $detail['nilai_skor'];
                $bukti = $this->buktiModel->getByDetail($detail['id']);
                $v['tautan_bukti'] = $bukti['tautan'] ?? '';

                // Ambil catatan revisi untuk detail ini
                $catatanRevisi = $db->table('catatan_revisi')
                    ->where('detail_id', $detail['id'])
                    ->where('status', 'TERBUKA')
                    ->orderBy('dibuat_pada', 'DESC')
                    ->get()->getResultArray();
                $v['catatan_revisi'] = $catatanRevisi;
            } else {
                $v['tingkat_id_terpilih'] = null;
                $v['nilai_skor']          = null;
                $v['tautan_bukti']        = '';
                $v['catatan_revisi']      = [];
            }
        }
        unset($v);

        $totalVariabel = count($variabel);
        $terisi        = $this->detailModel->hitungVariabelTerisi($penilaian['id']);
        $tabAktif      = (int) ($this->request->getGet('tab') ?? 0);

        $data = [
            'title'         => 'Pengisian Variabel',
            'penilaian'     => $penilaian,
            'periode'       => $periode,
            'variabel'      => $variabel,
            'totalVariabel' => $totalVariabel,
            'terisi'        => $terisi,
            'tabAktif'      => $tabAktif,
        ];

        return view('App\Modules\Penilaian\Views\form', $data);
    }

    public function simpan($variabelId)
    {
        $opdId  = session()->get('opd_id');
        $userId = session()->get('user_id');

        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/penilaian')->with('error', 'Periode tidak aktif.');
        }

        $penilaian = $this->penilaianModel->getOrCreate($opdId, $periode['id'], $userId);

        $tingkatId = $this->request->getPost('tingkat_id');
        $tautan    = trim($this->request->getPost('tautan_bukti'));

        if (empty($tingkatId)) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Pilih salah satu tingkat terlebih dahulu.');
        }

        if (empty($tautan)) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Link bukti wajib diisi.');
        }

        $db = \Config\Database::connect();
        $tingkat = $db->table('tingkat_penilaian')->where('id', $tingkatId)->get()->getRowArray();

        if (!$tingkat) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Tingkat tidak ditemukan.');
        }

        $existing = $this->detailModel->getByPenilaianAndVariabel($penilaian['id'], (int) $variabelId);

        if ($existing) {
            $this->detailModel->update($existing['id'], [
                'tingkat_id'      => $tingkatId,
                'nilai_skor'      => $tingkat['nilai'],
                'dilisi_oleh'     => $userId,
                'dilisi_pada'     => date('Y-m-d H:i:s'),
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ]);
            $detailId = $existing['id'];
        } else {
            $this->detailModel->insert([
                'penilaian_id' => $penilaian['id'],
                'variabel_id'  => $variabelId,
                'tingkat_id'   => $tingkatId,
                'nilai_skor'   => $tingkat['nilai'],
                'dilisi_oleh'  => $userId,
                'dilisi_pada'  => date('Y-m-d H:i:s'),
                'dibuat_pada'  => date('Y-m-d H:i:s'),
            ]);
            $detailId = $this->detailModel->getInsertID();
        }

        $this->buktiModel->simpanBukti($detailId, $tautan, $userId);

        // Kalau status PERLU_REVISI dan user sudah simpan, tetap PERLU_REVISI sampai submit ulang
        $statusBaru = $penilaian['status'];
        if ($statusBaru === 'TERVERIFIKASI') {
            $statusBaru = 'PERLU_VERIFIKASI_ULANG';
        }

        $totalSkor = $this->detailModel->hitungTotalSkor($penilaian['id']);
        $this->penilaianModel->update($penilaian['id'], [
            'status'          => $statusBaru,
            'total_skor'      => $totalSkor,
            'diperbarui_oleh' => $userId,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        $variabelBerikutnya = $this->cariVariabelBelumDiisi($penilaian['id']);

        if ($variabelBerikutnya === null) {
            return redirect()->to('/opd/kesimpulan')
                             ->with('success', 'Semua 11 variabel sudah terisi! Silakan cek kesimpulan.');
        }

        return redirect()->to('/opd/penilaian?tab=' . $variabelBerikutnya)
                         ->with('success', 'Variabel berhasil disimpan.');
    }

    private function cariVariabelBelumDiisi($penilaianId)
    {
        $db = \Config\Database::connect();

        $semuaVariabel = $db->table('variabel_penilaian')
            ->where('aktif', true)
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        $sudahDiisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaianId)
            ->get()->getResultArray();

        $idSudahDiisi = array_column($sudahDiisi, 'variabel_id');

        foreach ($semuaVariabel as $v) {
            if (!in_array($v['id'], $idSudahDiisi)) {
                return $v['id'];
            }
        }

        return null;
    }
}