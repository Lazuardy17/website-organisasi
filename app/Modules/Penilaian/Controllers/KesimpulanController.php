<?php

namespace App\Modules\Penilaian\Controllers;

use App\Controllers\BaseController;
use App\Modules\Penilaian\Models\PenilaianModel;
use App\Modules\Penilaian\Models\DetailPenilaianModel;

class KesimpulanController extends BaseController
{
    protected $penilaianModel;
    protected $detailModel;

    public function __construct()
    {
        $this->penilaianModel = new PenilaianModel();
        $this->detailModel    = new DetailPenilaianModel();
    }

    /**
     * Tampilkan halaman kesimpulan.
     */
    public function index()
    {
        $opdId = session()->get('opd_id');

        // Ambil periode aktif
        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/dashboard')->with('error', 'Tidak ada periode aktif.');
        }

        // Ambil penilaian OPD ini
        $penilaian = $this->penilaianModel
            ->where('opd_id', $opdId)
            ->where('periode_id', $periode['id'])
            ->first();

        if (!$penilaian) {
            return redirect()->to('/opd/penilaian')->with('error', 'Silakan isi variabel terlebih dahulu.');
        }

        // Ambil semua detail
        $detail = $this->detailModel->getByPenilaian($penilaian['id']);

        // Hitung total skor
        $totalSkor = 0;
        foreach ($detail as $d) {
            $totalSkor += (float) $d['nilai_skor'];
        }

        // Tentukan kesimpulan
        $kesimpulan = $this->tentukanKesimpulan($totalSkor);

        // Cek kelengkapan: hitung berapa variabel yang benar-benar terisi
        $db = \Config\Database::connect();
        $jumlahTerisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaian['id'])
            ->countAllResults();

        $lengkap = ($jumlahTerisi >= 11);

        $data = [
            'title'        => 'Kesimpulan & Hasil Evaluasi',
            'penilaian'    => $penilaian,
            'periode'      => $periode,
            'detail'       => $detail,
            'totalSkor'    => $totalSkor,
            'kesimpulan'   => $kesimpulan,
            'jumlahTerisi' => $jumlahTerisi,
            'lengkap'      => $lengkap,
        ];

        return view('App\Modules\Penilaian\Views\kesimpulan', $data);
    }

    /**
     * Submit penilaian ke Admin.
     */
    public function submit()
    {
        $opdId  = session()->get('opd_id');
        $userId = session()->get('user_id');

        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/kesimpulan')->with('error', 'Periode tidak aktif.');
        }

        $penilaian = $this->penilaianModel
            ->where('opd_id', $opdId)
            ->where('periode_id', $periode['id'])
            ->first();

        if (!$penilaian) {
            return redirect()->to('/opd/penilaian')->with('error', 'Silakan isi variabel terlebih dahulu.');
        }

        // Validasi: hitung langsung dari database
        $db = \Config\Database::connect();
        $jumlahTerisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaian['id'])
            ->countAllResults();

        if ($jumlahTerisi < 11) {
            return redirect()->to('/opd/kesimpulan')
                             ->with('error', 'Semua 11 variabel harus diisi sebelum submit. Baru terisi: ' . $jumlahTerisi);
        }

        // Ambil detail untuk hitung skor
        $detail = $this->detailModel->getByPenilaian($penilaian['id']);
        $totalSkor = 0;
        foreach ($detail as $d) {
            $totalSkor += (float) $d['nilai_skor'];
        }
        $kesimpulan = $this->tentukanKesimpulan($totalSkor);

        // Update status
        $this->penilaianModel->update($penilaian['id'], [
            'status'          => 'DIKIRIM',
            'total_skor'      => $totalSkor,
            'kesimpulan'      => $kesimpulan,
            'diajukan_pada'   => date('Y-m-d H:i:s'),
            'diperbarui_oleh' => $userId,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        // Catat riwayat
        $db->table('riwayat_status_penilaian')->insert([
            'penilaian_id'      => $penilaian['id'],
            'status_sebelumnya' => $penilaian['status'],
            'status_baru'       => 'DIKIRIM',
            'diubah_oleh'       => $userId,
            'alasan'            => 'User OPD mengajukan penilaian untuk diverifikasi.',
            'dibuat_pada'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/opd/kesimpulan')->with('success', 'Penilaian berhasil diajukan ke Admin.');
    }

    /**
     * Tentukan kesimpulan dari total skor.
     */
    private function tentukanKesimpulan($skor)
    {
        if ($skor >= 46.1) return 'Sangat Tinggi';
        if ($skor >= 37.1) return 'Tinggi';
        if ($skor >= 28.1) return 'Sedang';
        if ($skor >= 19.1) return 'Rendah';
        return 'Sangat Rendah';
    }
}