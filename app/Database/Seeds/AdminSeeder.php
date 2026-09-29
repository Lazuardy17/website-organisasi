<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Ambil peran_id untuk ADMIN
        $peranAdmin = $this->db->table('peran')
            ->where('kode', 'ADMIN')
            ->get()->getRow();

        if (!$peranAdmin) {
            echo "Error: Peran ADMIN tidak ditemukan. Jalankan PeranSeeder dulu.\n";
            return;
        }

        $data = [
            [
                'peran_id'         => $peranAdmin->id,
                'opd_id'           => null, // Admin tidak terikat OPD
                'nama_pengguna'    => 'admin',
                'hash_kata_sandi'  => password_hash('admin123', PASSWORD_DEFAULT),
                'alamat_surel'     => 'admin@banjarbaru.go.id',
                'status'           => 'AKTIF',
                'dibuat_pada'      => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('pengguna')->insertBatch($data);
    }
}