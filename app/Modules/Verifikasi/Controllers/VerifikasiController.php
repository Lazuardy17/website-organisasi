<?php

namespace App\Modules\Verifikasi\Controllers;

use App\Controllers\BaseController;
use App\Modules\Penilaian\Models\PenilaianModel;
use App\Modules\Penilaian\Models\DetailPenilaianModel;
use App\Modules\Penilaian\Models\BuktiPenilaianModel;
use App\Modules\Verifikasi\Models\VerifikasiModel;

class VerifikasiController extends BaseController
{
    protected $penilaianModel;
    protected $detailModel;
    protected $buktiModel;
    protected $verifikasiModel;

    public function __construct()
    {
        $this->penilaianModel  = new PenilaianModel();
        $this->detailModel     = new DetailPenilaianModel();
        $this->buktiModel      = new BuktiPenilaianModel();
        $this->verifikasiModel = new VerifikasiModel();
    }

    /**
     * Daftar penilaian yang menunggu verifikasi.
     */
    public function index()
    {
        // 10 penilaian per halaman (paginate() membaca ?page= dari URL)
        $daftar = $this->penilaianModel
            ->select('penilaian.*, 
                      perangkat_daerah.nama as nama_opd, 
                      perangkat_daerah.kode as kode_opd,
                      perangkat_daerah.nama_kepala,
                      periode_penilaian.tahun as tahun_periode')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->join('periode_penilaian', 'periode_penilaian.id = penilaian.periode_id', 'left')
            ->whereIn('penilaian.status', ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG'])
            ->orderBy('penilaian.diajukan_pada', 'ASC')
            ->orderBy('penilaian.id', 'ASC')   // urutan kedua agar halaman stabil
            ->paginate(10);

        $data = [
            'title'  => 'Verifikasi Penilaian',
            'daftar' => $daftar,
            'pager'  => $this->penilaianModel->pager,
        ];

        return view('App\Modules\Verifikasi\Views\index', $data);
    }

    /**
     * Detail penilaian + form verifikasi.
     */
    public function detail($id)
    {
        $db = \Config\Database::connect();
        $penilaian = $db->table('penilaian')
            ->select('penilaian.*, 
                      perangkat_daerah.nama as nama_opd, 
                      perangkat_daerah.kode as kode_opd,
                      perangkat_daerah.nama_kepala,
                      perangkat_daerah.nip_kepala,
                      perangkat_daerah.pangkat_kepala,
                      periode_penilaian.tahun as tahun_periode')
            ->join('perangkat_daerah', 'perangkat_daerah.id = penilaian.opd_id', 'left')
            ->join('periode_penilaian', 'periode_penilaian.id = penilaian.periode_id', 'left')
            ->where('penilaian.id', $id)
            ->get()->getRowArray();

        if (!$penilaian) {
            return redirect()->to('/admin/verifikasi')->with('error', 'Penilaian tidak ditemukan.');
        }

        $detail = $this->detailModel->getByPenilaian($id);
        foreach ($detail as &$d) {
            $bukti = $this->buktiModel->getByDetail($d['id']);
            $d['tautan_bukti']   = $bukti['tautan'] ?? '-';
            $d['catatan_revisi'] = $this->verifikasiModel->getCatatanByDetail($d['id']);
        }
        unset($d);

        $riwayat = $this->verifikasiModel->getByPenilaian($id);

        $data = [
            'title'     => 'Detail Verifikasi',
            'penilaian' => $penilaian,
            'detail'    => $detail,
            'riwayat'   => $riwayat,
        ];

        return view('App\Modules\Verifikasi\Views\detail', $data);
    }

    /**
     * Verifikasi: set status jadi TERVERIFIKASI.
     */
    public function verifikasi($id)
    {
        $userId = session()->get('user_id');

        $penilaian = $this->penilaianModel->find($id);
        if (!$penilaian) {
            return redirect()->to('/admin/verifikasi')->with('error', 'Penilaian tidak ditemukan.');
        }

        $this->verifikasiModel->insert([
            'penilaian_id'   => $id,
            'pemeriksa_id'   => $userId,
            'nomor_siklus'   => $this->verifikasiModel->getSiklusBerikutnya($id),
            'keputusan'      => 'DISETUJUI',
            'catatan'        => $this->request->getPost('catatan'),
            'diperiksa_pada' => date('Y-m-d H:i:s'),
        ]);

        $this->penilaianModel->update($id, [
            'status'            => 'TERVERIFIKASI',
            'diverifikasi_pada' => date('Y-m-d H:i:s'),
            'diperbarui_oleh'   => $userId,
            'diperbarui_pada'   => date('Y-m-d H:i:s'),
        ]);

        $db = \Config\Database::connect();
        $db->table('riwayat_status_penilaian')->insert([
            'penilaian_id'      => $id,
            'status_sebelumnya' => $penilaian['status'],
            'status_baru'       => 'TERVERIFIKASI',
            'diubah_oleh'       => $userId,
            'alasan'            => 'Admin menyetujui penilaian.',
            'dibuat_pada'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/verifikasi')->with('success', 'Penilaian berhasil diverifikasi.');
    }

    /**
     * Minta revisi: set status jadi PERLU_REVISI + simpan catatan.
     */
    public function revisi($id)
    {
        $userId        = session()->get('user_id');
        $catatanUmum   = $this->request->getPost('catatan');
        $catatanDetail = $this->request->getPost('catatan_detail');

        $penilaian = $this->penilaianModel->find($id);
        if (!$penilaian) {
            return redirect()->to('/admin/verifikasi')->with('error', 'Penilaian tidak ditemukan.');
        }

        if (empty($catatanUmum)) {
            return redirect()->back()->with('error', 'Catatan revisi wajib diisi.');
        }

        // Insert verifikasi
        $this->verifikasiModel->insert([
            'penilaian_id'   => $id,
            'pemeriksa_id'   => $userId,
            'nomor_siklus'   => $this->verifikasiModel->getSiklusBerikutnya($id),
            'keputusan'      => 'REVISION_REQUIRED',
            'catatan'        => $catatanUmum,
            'diperiksa_pada' => date('Y-m-d H:i:s'),
        ]);

        // Ambil ID verifikasi yang baru dibuat
        $verifikasiId = $this->verifikasiModel->getInsertID();

        if (!$verifikasiId) {
            return redirect()->back()->with('error', 'Gagal menyimpan verifikasi.');
        }

        // Simpan catatan per detail (kalau ada)
        if (!empty($catatanDetail) && is_array($catatanDetail)) {
            foreach ($catatanDetail as $detailId => $catatan) {
                if (!empty(trim($catatan))) {
                    $this->verifikasiModel->simpanCatatan((int) $verifikasiId, (int) $detailId, trim($catatan));
                }
            }
        }

        // Update status penilaian
        $this->penilaianModel->update($id, [
            'status'          => 'PERLU_REVISI',
            'diperbarui_oleh' => $userId,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        // Catat riwayat
        $db = \Config\Database::connect();
        $db->table('riwayat_status_penilaian')->insert([
            'penilaian_id'      => $id,
            'status_sebelumnya' => $penilaian['status'],
            'status_baru'       => 'PERLU_REVISI',
            'diubah_oleh'       => $userId,
            'alasan'            => $catatanUmum,
            'dibuat_pada'       => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/verifikasi')->with('success', 'Penilaian dikembalikan untuk revisi.');
    }
}