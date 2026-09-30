<?php

namespace App\Modules\OPD\Controllers;

use App\Controllers\BaseController;
use App\Modules\OPD\Models\AkunOpdModel;

class AkunOpdController extends BaseController
{
    protected $akunModel;

    public function __construct()
    {
        $this->akunModel = new AkunOpdModel();
    }

    /* =========================================================
     * READ — Daftar Akun OPD
     * ========================================================= */

    public function index()
    {
        $data = [
            'title' => 'Manajemen Akun OPD',
            'akun'  => $this->akunModel
                ->select('pengguna.*, perangkat_daerah.nama as nama_opd, perangkat_daerah.kode as kode_opd, perangkat_daerah.nama_kepala, perangkat_daerah.nip_kepala')
                ->join('perangkat_daerah', 'perangkat_daerah.id = pengguna.opd_id', 'left')
                ->where('pengguna.peran_id', 2)
                ->orderBy('perangkat_daerah.nama', 'ASC')
                ->findAll(),
        ];

        return view('App\Modules\OPD\Views\index', $data);
    }

    /* =========================================================
     * CREATE — Tambah Akun OPD
     * ========================================================= */

    public function create()
    {
        $db = \Config\Database::connect();

        $opdBelumPunyaAkun = $db->table('perangkat_daerah')
            ->whereNotIn('id', function ($builder) {
                return $builder->select('opd_id')->from('pengguna')->where('opd_id IS NOT NULL');
            })
            ->where('status', 'AKTIF')
            ->orderBy('nama', 'ASC')
            ->get()->getResultArray();

        $data = [
            'title' => 'Tambah Akun OPD',
            'opd'   => $opdBelumPunyaAkun,
        ];

        return view('App\Modules\OPD\Views\form', $data);
    }

    public function store()
    {
        $opdId = (int) $this->request->getPost('opd_id');

        if (!$opdId) {
            return redirect()->back()->with('error', 'Pilih OPD terlebih dahulu.')->withInput();
        }

        if ($this->akunModel->cekOpdSudahPunyaAkun($opdId)) {
            return redirect()->back()->with('error', 'OPD ini sudah punya akun.')->withInput();
        }

        $db  = \Config\Database::connect();
        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();

        if (!$opd) {
            return redirect()->back()->with('error', 'OPD tidak ditemukan.')->withInput();
        }

        $nipKepala  = $this->request->getPost('nip_kepala');
        $namaKepala = $this->request->getPost('nama_kepala');
        $password   = $this->request->getPost('password');
        $konfirmasi = $this->request->getPost('konfirmasi');

        // ============ Validasi ============
        if (empty($password)) {
            return redirect()->back()->with('error', 'Kata sandi wajib diisi.')->withInput();
        }

        if (strlen($password) < 8) {
            return redirect()->back()->with('error', 'Kata sandi minimal 8 karakter.')->withInput();
        }

        if ($password !== $konfirmasi) {
            return redirect()->back()->with('error', 'Kata sandi dan konfirmasi tidak sama.')->withInput();
        }

        if (empty($nipKepala)) {
            return redirect()->back()->with('error', 'NIP wajib diisi.')->withInput();
        }

        if (empty($namaKepala)) {
            return redirect()->back()->with('error', 'Nama Kepala OPD wajib diisi.')->withInput();
        }

        // ============ Update perangkat_daerah ============
        $db->table('perangkat_daerah')
            ->where('id', $opdId)
            ->update([
                'nip_kepala'      => $nipKepala,
                'nama_kepala'     => $namaKepala,
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ]);

        $username = strtolower($opd['kode']);

        $this->akunModel->insert([
            'peran_id'        => 2,
            'opd_id'          => $opdId,
            'nama_pengguna'   => $username,
            'hash_kata_sandi' => password_hash($password, PASSWORD_DEFAULT),
            'status'          => 'AKTIF',
            'dibuat_pada'     => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('akun_baru', [
            'username' => $username,
            'password' => $password,
            'nama_opd' => $opd['nama'],
        ]);

        return redirect()->to('/admin/akun-opd');
    }

    /* =========================================================
     * READ — Detail Akun OPD
     * ========================================================= */

    public function detail($id)
    {
        $akun = $this->akunModel
            ->select('pengguna.*, perangkat_daerah.nama as nama_opd, perangkat_daerah.kode as kode_opd')
            ->join('perangkat_daerah', 'perangkat_daerah.id = pengguna.opd_id', 'left')
            ->where('pengguna.id', $id)
            ->first();

        if (!$akun) {
            return redirect()->to('/admin/akun-opd')->with('error', 'Akun tidak ditemukan.');
        }

        $data = [
            'title' => 'Detail Akun OPD',
            'akun'  => $akun,
        ];

        return view('App\Modules\OPD\Views\detail', $data);
    }

    /* =========================================================
     * UPDATE — Edit Akun OPD
     * ========================================================= */

    public function edit($id)
    {
        $akun = $this->akunModel
            ->select('pengguna.*, perangkat_daerah.nama as nama_opd, perangkat_daerah.kode as kode_opd, perangkat_daerah.nama_kepala, perangkat_daerah.nip_kepala')
            ->join('perangkat_daerah', 'perangkat_daerah.id = pengguna.opd_id', 'left')
            ->where('pengguna.id', $id)
            ->first();

        if (!$akun) {
            return redirect()->to('/admin/akun-opd')->with('error', 'Akun tidak ditemukan.');
        }

        return view('App\Modules\OPD\Views\edit', [
            'title' => 'Edit Akun OPD',
            'akun'  => $akun,
        ]);
    }

    public function update($id)
    {
        $akun = $this->akunModel->find($id);

        if (!$akun) {
            return redirect()->to('/admin/akun-opd')->with('error', 'Akun tidak ditemukan.');
        }

        $namaPengguna = trim($this->request->getPost('nama_pengguna'));
        $namaOpd      = trim($this->request->getPost('nama_opd'));
        $nipKepala    = $this->request->getPost('nip_kepala');
        $namaKepala   = $this->request->getPost('nama_kepala');
        $password     = $this->request->getPost('password');
        $konfirmasi   = $this->request->getPost('konfirmasi');

        // ============ Validasi ============
        if (empty($namaPengguna)) {
            return redirect()->back()->with('error', 'Username wajib diisi.')->withInput();
        }

        if (empty($namaOpd)) {
            return redirect()->back()->with('error', 'Nama OPD wajib diisi.')->withInput();
        }

        if (empty($nipKepala)) {
            return redirect()->back()->with('error', 'NIP wajib diisi.')->withInput();
        }

        if (empty($namaKepala)) {
            return redirect()->back()->with('error', 'Nama Kepala OPD wajib diisi.')->withInput();
        }

        // Cek username unik
        $cekUsername = $this->akunModel->where('nama_pengguna', $namaPengguna)
                                       ->where('id !=', $id)
                                       ->first();

        if ($cekUsername) {
            return redirect()->back()->with('error', 'Username sudah dipakai akun lain.')->withInput();
        }

        // Validasi password (HANYA kalau diisi)
        if (!empty($password)) {
            if (strlen($password) < 8) {
                return redirect()->back()->with('error', 'Kata sandi minimal 8 karakter.')->withInput();
            }
            if ($password !== $konfirmasi) {
                return redirect()->back()->with('error', 'Kata sandi dan konfirmasi tidak sama.')->withInput();
            }
        }

        // ============ Update perangkat_daerah ============
        if ($akun['opd_id']) {
            $db = \Config\Database::connect();
            $db->table('perangkat_daerah')
                ->where('id', $akun['opd_id'])
                ->update([
                    'nama'            => $namaOpd,
                    'nip_kepala'      => $nipKepala,
                    'nama_kepala'     => $namaKepala,
                    'diperbarui_pada' => date('Y-m-d H:i:s'),
                ]);
        }

        // ============ Update pengguna ============
        $updatePengguna = [
            'nama_pengguna'   => $namaPengguna,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ];

        if (!empty($password)) {
            $updatePengguna['hash_kata_sandi'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->akunModel->update($id, $updatePengguna);

        return redirect()->to('/admin/akun-opd')->with('success', 'Akun berhasil diperbarui.');
    }

    /* =========================================================
     * ACTION — Reset Password
     * ========================================================= */

    public function resetPassword($id)
    {
        $akun = $this->akunModel->find($id);

        if (!$akun) {
            return redirect()->to('/admin/akun-opd')->with('error', 'Akun tidak ditemukan.');
        }

        $passwordBaru = bin2hex(random_bytes(4));

        $this->akunModel->update($id, [
            'hash_kata_sandi' => password_hash($passwordBaru, PASSWORD_DEFAULT),
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        session()->setFlashdata('password_sementara', $passwordBaru);
        session()->setFlashdata('username_baru', $akun['nama_pengguna']);

        return redirect()->to('/admin/akun-opd/detail/' . $id);
    }

    /* =========================================================
     * ACTION — Aktif/Nonaktifkan Akun
     * ========================================================= */

    public function toggleStatus($id)
    {
        $akun = $this->akunModel->find($id);

        if (!$akun) {
            return redirect()->to('/admin/akun-opd')->with('error', 'Akun tidak ditemukan.');
        }

        $statusBaru = ($akun['status'] === 'AKTIF') ? 'INAKTIF' : 'AKTIF';

        $this->akunModel->update($id, [
            'status'          => $statusBaru,
            'diperbarui_pada' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/admin/akun-opd')->with('success', 'Status akun berhasil diubah menjadi ' . $statusBaru . '.');
    }
}