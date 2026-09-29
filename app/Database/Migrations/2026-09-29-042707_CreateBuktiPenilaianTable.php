<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBuktiPenilaianTable extends Migration
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
            'detail_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'jenis_bukti' => [
                'type'       => 'ENUM',
                'constraint' => ['TAUTAN', 'BERKAS'],
                'default'    => 'TAUTAN',
            ],
            'judul' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'tautan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'lokasi_berkas' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'deskripsi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'diunggah_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
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
        $this->forge->addForeignKey('detail_id', 'detail_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('diunggah_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('bukti_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('bukti_penilaian');
    }
}