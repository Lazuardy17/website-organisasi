<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRiwayatStatusPenilaianTable extends Migration
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
            'status_sebelumnya' => [
                'type'       => 'ENUM',
                'constraint' => ['DRAF', 'DIKIRIM', 'PERLU_REVISI', 'TERVERIFIKASI', 'PERLU_VERIFIKASI_ULANG'],
                'null'       => true,
            ],
            'status_baru' => [
                'type'       => 'ENUM',
                'constraint' => ['DRAF', 'DIKIRIM', 'PERLU_REVISI', 'TERVERIFIKASI', 'PERLU_VERIFIKASI_ULANG'],
            ],
            'diubah_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
            'alasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'dibuat_pada' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('penilaian_id', 'penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('diubah_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('riwayat_status_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('riwayat_status_penilaian');
    }
}