<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCatatanRevisiTable extends Migration
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
            'verifikasi_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'detail_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['TERBUKA', 'SELESAI'],
                'default'    => 'TERBUKA',
            ],
            'diselesaikan_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
            'diselesaikan_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'diperbarui_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('verifikasi_id', 'verifikasi_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('detail_id', 'detail_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('diselesaikan_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('catatan_revisi');
    }

    public function down()
    {
        $this->forge->dropTable('catatan_revisi');
    }
}