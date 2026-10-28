<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePercobaanLoginTable extends Migration
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
            'nama_pengguna' => ['type' => 'VARCHAR', 'constraint' => 100],
            'alamat_ip'     => ['type' => 'VARCHAR', 'constraint' => 45],
            'jumlah_gagal'  => ['type' => 'INT', 'constraint' => 5, 'unsigned' => true, 'default' => 0],
            'terkunci_sampai'    => ['type' => 'DATETIME', 'null' => true],
            'percobaan_terakhir' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['nama_pengguna', 'alamat_ip']);
        $this->forge->createTable('percobaan_login');
    }

    public function down()
    {
        $this->forge->dropTable('percobaan_login');
    }
}