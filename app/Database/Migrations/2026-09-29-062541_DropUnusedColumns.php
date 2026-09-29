<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DropUnusedColumns extends Migration
{
    public function up()
    {
        // Hapus kolom dari tabel perangkat_daerah
        $this->forge->dropColumn('perangkat_daerah', 'alamat');
        $this->forge->dropColumn('perangkat_daerah', 'telepon');

        // Hapus kolom dari tabel pengguna
        $this->forge->dropColumn('pengguna', 'nama_lengkap');
    }

    public function down()
    {
        // Kalau di-rollback, kolom akan dikembalikan
        $this->forge->addColumn('perangkat_daerah', [
            'alamat' => ['type' => 'TEXT', 'null' => true, 'after' => 'pangkat_kepala'],
            'telepon' => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true, 'after' => 'alamat'],
        ]);

        $this->forge->addColumn('pengguna', [
            'nama_lengkap' => ['type' => 'VARCHAR', 'constraint' => 150, 'after' => 'opd_id'],
        ]);
    }
}