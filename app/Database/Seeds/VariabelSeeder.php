<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class VariabelSeeder extends Seeder
{
    public function run()
    {
        $data = [
            ['kode' => 'VAR01', 'nama' => 'Perencanaan', 'nomor_urutan' => 1, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR02', 'nama' => 'Monitoring & Pengendalian Pelaksanaan Tugas', 'nomor_urutan' => 2, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR03', 'nama' => 'Penjaminan Mutu Layanan', 'nomor_urutan' => 3, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR04', 'nama' => 'SOP Pelayanan', 'nomor_urutan' => 4, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR05', 'nama' => 'Pendidikan dan Pelatihan Aparatur', 'nomor_urutan' => 5, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR06', 'nama' => 'Analisis Kebijakan dan Pemecahan Masalah', 'nomor_urutan' => 6, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR07', 'nama' => 'Manajemen Sumber Daya Peralatan & Perlengkapan Kerja', 'nomor_urutan' => 7, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR08', 'nama' => 'Manajemen Resiko Pelaksanaan Tugas', 'nomor_urutan' => 8, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR09', 'nama' => 'Pengukuran Kinerja', 'nomor_urutan' => 9, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR10', 'nama' => 'Pengembangan Inovasi Layanan', 'nomor_urutan' => 10, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'VAR11', 'nama' => 'Budaya Organisasi', 'nomor_urutan' => 11, 'aktif' => true, 'dibuat_pada' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('variabel_penilaian')->insertBatch($data);
    }
}