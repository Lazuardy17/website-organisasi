<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class IdentitasFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Skip kalau bukan OPD
        if (session()->get('peran_id') != 2) {
            return;
        }

        $currentUrl = current_url();

        // Halaman yang boleh diakses meski identitas belum lengkap
        $allowed = [
            '/opd/identitas',
            '/opd/identitas/simpan',
            '/logout',
        ];

        foreach ($allowed as $path) {
            if (strpos($currentUrl, $path) !== false) {
                return;   // Lanjut ke halaman
            }
        }

        // CEK DATABASE SETIAP REQUEST (bukan cuma session)
        $db  = \Config\Database::connect();
        $opd = $db->table('perangkat_daerah')
            ->where('id', session()->get('opd_id'))
            ->get()->getRowArray();

        $identitasLengkap = $opd && !empty($opd['identitas_lengkap']);

        // UPDATE SESSION — sinkron dengan DB
        session()->set('identitas_lengkap', $identitasLengkap);

        // Kalau belum lengkap → redirect ke form identitas
        if (!$identitasLengkap) {
            return redirect()->to('/opd/identitas')
                             ->with('error', 'Lengkapi identitas terlebih dahulu.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing
    }
}