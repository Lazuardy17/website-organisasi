<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVerifikasiPenilaianTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'penilaian_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'pemeriksa_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'nomor_siklus' => [
                'type'       => 'INT',
                'constraint' => 10,
                'unsigned'   => true,
            ],
            'keputusan' => [
                'type'       => 'ENUM',
                'constraint' => ['DISETUJUI', 'REVISION_REQUIRED'],
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diperiksa_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penilaian_id', 'penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('pemeriksa_id', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('verifikasi_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('verifikasi_penilaian');
    }
}