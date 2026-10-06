<?php

namespace App\Modules\OPD\Controllers;

use App\Controllers\BaseController;

class AkunController extends BaseController
{
    /**
     * Tampilkan halaman akun OPD.
     */
    public function index()
    {
        $opdId = session()->get('opd_id');
        $db    = \Config\Database::connect();

        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();

        if (!$opd) {
            return redirect()->to('/opd/dashboard')->with('error', 'Data OPD tidak ditemukan.');
        }

        $data = [
            'title' => 'Akun Perangkat Daerah',
            'opd'   => $opd,
        ];

        return view('App\Modules\OPD\Views\opd\akun', $data);
    }

    /**
     * Update data akun OPD.
     */
    public function update()
    {
        $opdId = session()->get('opd_id');
        $db    = \Config\Database::connect();

        $namaOpd       = trim($this->request->getPost('nama'));
        $namaKepala    = trim($this->request->getPost('nama_kepala'));
        $nipKepala     = trim($this->request->getPost('nip_kepala'));
        $pangkatKepala = trim($this->request->getPost('pangkat_kepala'));

        // Validasi
        if (empty($namaOpd)) {
            return redirect()->back()->with('error', 'Nama OPD wajib diisi.');
        }

        if (empty($namaKepala)) {
            return redirect()->back()->with('error', 'Nama Kepala OPD wajib diisi.');
        }

        if (empty($nipKepala)) {
            return redirect()->back()->with('error', 'NIP wajib diisi.');
        }

        if (empty($pangkatKepala)) {
            return redirect()->back()->with('error', 'Pangkat/Golongan wajib diisi.');
        }

        // Update tabel perangkat_daerah
        $db->table('perangkat_daerah')
            ->where('id', $opdId)
            ->update([
                'nama'            => $namaOpd,
                'nama_kepala'     => $namaKepala,
                'nip_kepala'      => $nipKepala,
                'pangkat_kepala'  => $pangkatKepala,
                'diperbarui_pada' => date('Y-m-d H:i:s'),
            ]);

        return redirect()->to('/opd/akun')->with('success', 'Data akun berhasil diperbarui.');
    }
}