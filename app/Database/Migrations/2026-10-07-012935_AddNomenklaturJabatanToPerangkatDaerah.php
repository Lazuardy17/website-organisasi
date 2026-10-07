<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddNomenklaturJabatanToPerangkatDaerah extends Migration
{
    public function up()
    {
        $this->forge->addColumn('perangkat_daerah', [
            'nomenklatur_jabatan' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'nama',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('perangkat_daerah', 'nomenklatur_jabatan');
    }
}