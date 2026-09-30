<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek login
        if (!session()->get('is_logged_in')) {
            return redirect()->to('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek role (kalau ada argumen)
        if (!empty($arguments)) {
            $peranDiperlukan = $arguments[0]; // 'admin' atau 'opd'
            $peranId = session()->get('peran_id');

            // peran_id 1 = ADMIN, 2 = USER_OPD
            $peranUser = ($peranId == 1) ? 'admin' : 'opd';

            if ($peranUser !== $peranDiperlukan) {
                $tujuan = ($peranUser === 'admin') ? '/admin/dashboard' : '/opd/dashboard';
                return redirect()->to($tujuan)->with('error', 'Anda tidak punya akses ke halaman itu.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada yang perlu dilakukan
    }
}