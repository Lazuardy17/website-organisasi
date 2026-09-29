<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVariabelPenilaianTable extends Migration
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
            'kode' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'unique'     => true,
            ],
            'nama' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'penjelasan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nomor_urutan' => [
                'type'       => 'TINYINT',
                'constraint' => 3,
                'unsigned'   => true,
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
        $this->forge->createTable('variabel_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('variabel_penilaian');
    }
}