<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'tahun'           => 2026,
                'nama'            => 'Penilaian Tahun 2026',
                'tanggal_mulai'   => '2026-01-01',
                'tanggal_selesai' => '2026-12-31',
                'status'          => 'TERBUKA',
                'dibuat_pada'     => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('periode_penilaian')->insertBatch($data);
    }
}