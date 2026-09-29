<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PeranSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'kode' => 'ADMIN',
                'nama' => 'Administrator',
                'dibuat_pada' => date('Y-m-d H:i:s'),
            ],
            [
                'kode' => 'USER_OPD',
                'nama' => 'User OPD',
                'dibuat_pada' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('peran')->insertBatch($data);
    }
}