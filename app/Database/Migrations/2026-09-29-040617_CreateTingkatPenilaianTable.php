<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTingkatPenilaianTable extends Migration
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
            'variabel_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'nomor_tingkat' => [
                'type'       => 'TINYINT',
                'constraint' => 2,
                'unsigned'   => true,
            ],
            'nama_tingkat' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'indikator' => [
                'type' => 'TEXT',
            ],
            'nilai' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'default'    => 0,
            ],
            'aktif' => [
                'type'    => 'BOOLEAN',
                'default' => true,
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
        $this->forge->addForeignKey('variabel_id', 'variabel_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('tingkat_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('tingkat_penilaian');
    }
}