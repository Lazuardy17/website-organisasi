<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddIdentitasLengkapToPerangkatDaerah extends Migration
{
    public function up()
    {
        $this->forge->addColumn('perangkat_daerah', [
            'identitas_lengkap' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
                'after'      => 'pangkat_kepala',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('perangkat_daerah', 'identitas_lengkap');
    }
}