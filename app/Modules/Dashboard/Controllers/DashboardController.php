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
        ];

        return view('App\Modules\Dashboard\Views\admin', $data);
    }

    public function opd()
    {
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