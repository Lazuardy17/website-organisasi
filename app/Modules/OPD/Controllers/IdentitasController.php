<?php

namespace App\Modules\OPD\Controllers;

use App\Controllers\BaseController;

class IdentitasController extends BaseController
{
    public function index()
    {
        $db      = \Config\Database::connect();
        $opdId   = session()->get('opd_id');

        $opd = $db->table('perangkat_daerah')->where('id', $opdId)->get()->getRowArray();

        if (!$opd) {
            return redirect()->to('/opd/dashboard')->with('error', 'Data OPD tidak ditemukan.');
        }

        if (!empty($opd['identitas_lengkap'])) {
            return redirect()->to('/opd/dashboard');
        }

        $data = [
            'title' => 'Evaluasi Kematangan Kelembagaan',
            'opd'   => $opd,
        ];

        return view('App\Modules\OPD\Views\opd\identitas', $data);
    }

    public function simpan()
    {
        $db    = \Config\Database::connect();
        $opdId = session()->get('opd_id');

        $namaKepala    = trim($this->request->getPost('nama_kepala'));
        $pangkatKepala = trim($this->request->getPost('pangkat_kepala'));
        $nipKepala     = trim($this->request->getPost('nip_kepala'));

        // Validasi
        if (empty($namaKepala) || empty($pangkatKepala) || empty($nipKepala)) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.')->withInput();
        }

        // Update data OPD
        $db->table('perangkat_daerah')
            ->where('id', $opdId)
            ->update([
                'nama_kepala'       => $namaKepala,
                'pangkat_kepala'    => $pangkatKepala,
                'nip_kepala'        => $nipKepala,
                'identitas_lengkap' => true,
                'diperbarui_pada'   => date('Y-m-d H:i:s'),
            ]);

        session()->set('identitas_lengkap', true);

        return redirect()->to('/opd/dashboard')->with('success', 'Data identitas berhasil disimpan.');
    }
}