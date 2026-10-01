<?php

namespace App\Modules\Dashboard\Controllers;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function admin()
    {
        $data = [
            'title'          => 'Dashboard Admin',
            'total_opd'      => 0,
            'belum_submit'   => 0,
            'menunggu_verif' => 0,
            'terverifikasi'  => 0,
            'antrean'        => [],
        ];

        return view('App\Modules\Dashboard\Views\admin', $data);
    }

    public function opd()
    {
        // Cek identitas lengkap
        $db  = \Config\Database::connect();
        $opd = $db->table('perangkat_daerah')
            ->where('id', session()->get('opd_id'))
            ->get()->getRowArray();

        if ($opd && empty($opd['identitas_lengkap'])) {
            return redirect()->to('/opd/identitas')->with('error', 'Lengkapi identitas terlebih dahulu.');
        }

        $data = [
            'title'          => 'Dashboard OPD',
            'total_variabel' => 11,
            'belum_diisi'    => 11,
            'status'         => 'DRAFT',
            'skor'           => null,
        ];

        return view('App\Modules\Dashboard\Views\user', $data);
    }
}