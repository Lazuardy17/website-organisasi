<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddVerifikasiBuktiToTingkatPenilaian extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tingkat_penilaian', [
            'verifikasi_bukti' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'indikator',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tingkat_penilaian', 'verifikasi_bukti');
    }
}