<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePenilaianTable extends Migration
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
            'opd_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'periode_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['DRAFT', 'DIKIRIM', 'PERLU_REVISI', 'TERVERIFIKASI', 'PERLU_VERIFIKASI_ULANG'],
                'default'    => 'DRAFT',
            ],
            'total_skor' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'null'       => true,
            ],
            'kesimpulan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diajukan_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'diverifikasi_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'dibuat_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'diperbarui_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
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
        $this->forge->addForeignKey('opd_id', 'perangkat_daerah', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('periode_id', 'periode_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('dibuat_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('diperbarui_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('penilaian');
    }
}