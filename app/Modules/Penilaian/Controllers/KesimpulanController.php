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

    public function index()
    {
        $opdId = session()->get('opd_id');

        $periode = $this->penilaianModel->getPeriodeAktif();
        if (!$periode) {
            return redirect()->to('/opd/dashboard')->with('error', 'Tidak ada periode aktif.');
        }

        $penilaian = $this->penilaianModel
            ->where('opd_id', $opdId)
            ->where('periode_id', $periode['id'])
            ->first();

        if (!$penilaian) {
            return redirect()->to('/opd/penilaian')->with('error', 'Silakan isi variabel terlebih dahulu.');
        }

        $detail = $this->detailModel->getByPenilaian($penilaian['id']);

        $totalSkor = 0;
        foreach ($detail as $d) {
            $totalSkor += (float) $d['nilai_skor'];
        }

        $kesimpulan = $this->tentukanKesimpulan($totalSkor);

        $db = \Config\Database::connect();
        $jumlahTerisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaian['id'])
            ->countAllResults();

        $lengkap = ($jumlahTerisi >= 11);

        // Ambil catatan revisi umum (detail_id NULL)
        $catatanUmum = $db->table('catatan_revisi')
            ->whereIn('verifikasi_id', function ($builder) use ($penilaian) {
                return $builder->select('id')->from('verifikasi_penilaian')
                               ->where('penilaian_id', $penilaian['id']);
            })
            ->where('detail_id IS NULL')
            ->where('status', 'TERBUKA')
            ->orderBy('dibuat_pada', 'DESC')
            ->get()->getResultArray();

        $data = [
            'title'        => 'Kesimpulan & Hasil Evaluasi',
            'penilaian'    => $penilaian,
            'periode'      => $periode,
            'detail'       => $detail,
            'totalSkor'    => $totalSkor,
            'kesimpulan'   => $kesimpulan,
            'jumlahTerisi' => $jumlahTerisi,
            'lengkap'      => $lengkap,
            'catatanUmum'  => $catatanUmum,
        ];

        return view('App\Modules\Penilaian\Views\kesimpulan', $data);
    }

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

        $db = \Config\Database::connect();
        $jumlahTerisi = $db->table('detail_penilaian')
            ->where('penilaian_id', $penilaian['id'])
            ->countAllResults();

        if ($jumlahTerisi < 11) {
            return redirect()->to('/opd/kesimpulan')
                             ->with('error', 'Semua 11 variabel harus diisi sebelum submit. Baru terisi: ' . $jumlahTerisi);
        }

        $detail = $this->detailModel->getByPenilaian($penilaian['id']);
        $totalSkor = 0;
        foreach ($detail as $d) {
            $totalSkor += (float) $d['nilai_skor'];
        }
        $kesimpulan = $this->tentukanKesimpulan($totalSkor);

        $this->penilaianModel->update($penilaian['id'], [
            'status'          => 'DIKIRIM',
            'total_skor'      => $totalSkor,
            'kesimpulan'      => $kesimpulan,
            'diajukan_pada'   => date('Y-m-d H:i:s'),
            'diperbarui_oleh' => $userId,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        // Tentukan alasan riwayat
        $alasan = ($penilaian['status'] === 'PERLU_REVISI') 
            ? 'User OPD mengajukan ulang setelah revisi.'
            : 'User OPD mengajukan penilaian untuk diverifikasi.';

        $db->table('riwayat_status_penilaian')->insert([
            'penilaian_id'      => $penilaian['id'],
            'status_sebelumnya' => $penilaian['status'],
            'status_baru'       => 'DIKIRIM',
            'diubah_oleh'       => $userId,
            'alasan'            => $alasan,
            'dibuat_pada'       => date('Y-m-d H:i:s'),
        ]);

        // Tandai catatan revisi sebagai SELESAI
        $db->table('catatan_revisi')
            ->whereIn('verifikasi_id', function ($builder) use ($penilaian) {
                return $builder->select('id')->from('verifikasi_penilaian')
                               ->where('penilaian_id', $penilaian['id']);
            })
            ->where('status', 'TERBUKA')
            ->update([
                'status'            => 'SELESAI',
                'diselesaikan_oleh' => $userId,
                'diselesaikan_pada' => date('Y-m-d H:i:s'),
            ]);

        return redirect()->to('/opd/kesimpulan')->with('success', 'Penilaian berhasil diajukan ulang ke Admin.');
    }

    private function tentukanKesimpulan($skor)
    {
        if ($skor >= 46.1) return 'Sangat Tinggi';
        if ($skor >= 37.1) return 'Tinggi';
        if ($skor >= 28.1) return 'Sedang';
        if ($skor >= 19.1) return 'Rendah';
        return 'Sangat Rendah';
    }
}