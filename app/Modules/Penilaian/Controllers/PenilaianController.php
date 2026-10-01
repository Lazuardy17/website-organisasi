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

    /**
     * Halaman pengisian 11 variabel.
     */
    public function index()
    {
        $opdId  = session()->get('opd_id');
        $userId = session()->get('user_id');

        // Ambil periode aktif
        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/dashboard')->with('error', 'Tidak ada periode penilaian yang aktif.');
        }

        // Ambil atau buat header penilaian
        $penilaian = $this->penilaianModel->getOrCreate($opdId, $periode['id'], $userId);

        // Ambil 11 variabel beserta 5 tingkat masing-masing
        $db = \Config\Database::connect();
        $variabel = $db->table('variabel_penilaian')
            ->where('aktif', true)
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        // Untuk setiap variabel, ambil 5 tingkat + jawaban sebelumnya
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
            } else {
                $v['tingkat_id_terpilih'] = null;
                $v['nilai_skor']          = null;
                $v['tautan_bukti']        = '';
            }
        }
        unset($v);

        // Hitung progres
        $totalVariabel = count($variabel);
        $terisi        = $this->detailModel->hitungVariabelTerisi($penilaian['id']);

        // Baca parameter ?tab= dari URL
        $tabAktif = (int) ($this->request->getGet('tab') ?? 0);

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

    /**
     * Simpan draft untuk satu variabel.
     */
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

        // Validasi — kalau gagal, kembali ke variabel yang sama
        if (empty($tingkatId)) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Pilih salah satu tingkat terlebih dahulu.');
        }

        if (empty($tautan)) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Link bukti wajib diisi.');
        }

        // Ambil nilai skor dari tabel tingkat_penilaian
        $db = \Config\Database::connect();
        $tingkat = $db->table('tingkat_penilaian')->where('id', $tingkatId)->get()->getRowArray();

        if (!$tingkat) {
            return redirect()->to('/opd/penilaian?tab=' . $variabelId)
                             ->with('error', 'Tingkat tidak ditemukan.');
        }

        // Cek apakah sudah ada detail untuk variabel ini
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

        // Simpan bukti
        $this->buktiModel->simpanBukti($detailId, $tautan, $userId);

        // Update total skor di header penilaian
        $totalSkor = $this->detailModel->hitungTotalSkor($penilaian['id']);
        $this->penilaianModel->update($penilaian['id'], [
            'total_skor'      => $totalSkor,
            'diperbarui_oleh' => $userId,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        // Cari variabel terkecil yang BELUM diisi
        $variabelBerikutnya = $this->cariVariabelBelumDiisi($penilaian['id']);

        // Kalau semua sudah terisi, arahkan ke kesimpulan
        if ($variabelBerikutnya === null) {
            return redirect()->to('/opd/kesimpulan')
                             ->with('success', 'Semua 11 variabel sudah terisi! Silakan cek kesimpulan.');
        }

        return redirect()->to('/opd/penilaian?tab=' . $variabelBerikutnya)
                         ->with('success', 'Variabel berhasil disimpan.');
    }

    /**
     * Cari variabel dengan nomor_urutan terkecil yang belum diisi.
     */
    private function cariVariabelBelumDiisi($penilaianId)
    {
        $db = \Config\Database::connect();

        // Ambil semua variabel yang aktif, urut
        $semuaVariabel = $db->table('variabel_penilaian')
            ->where('aktif', true)
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        // Ambil variabel yang sudah diisi
        $sudahDiisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaianId)
            ->get()->getResultArray();

        $idSudahDiisi = array_column($sudahDiisi, 'variabel_id');

        // Cari yang belum
        foreach ($semuaVariabel as $v) {
            if (!in_array($v['id'], $idSudahDiisi)) {
                return $v['id'];
            }
        }

        return null; // Semua sudah diisi
    }
}