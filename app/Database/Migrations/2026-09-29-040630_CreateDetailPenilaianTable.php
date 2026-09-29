<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetailPenilaianTable extends Migration
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
            'variabel_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'tingkat_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'nilai_skor' => [
                'type'       => 'DECIMAL',
                'constraint' => '8,2',
                'default'    => 0,
            ],
            'dilisi_oleh' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],
            'dilisi_pada' => [
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
        $this->forge->addForeignKey('penilaian_id', 'penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('variabel_id', 'variabel_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('tingkat_id', 'tingkat_penilaian', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('dilisi_oleh', 'pengguna', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('detail_penilaian');
    }

    public function down()
    {
        $this->forge->dropTable('detail_penilaian');
    }
}