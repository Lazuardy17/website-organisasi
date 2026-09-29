<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PerangkatDaerahSeeder extends Seeder
{
    public function run()
    {
        // 35 OPD Kota Banjarbaru
        $data = [
            ['kode' => 'SETDA', 'nama' => 'SEKRETARIAT DAERAH', 'nama_kepala' => 'Sekretaris Daerah', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'SETDPRD', 'nama' => 'SEKRETARIAT DPRD', 'nama_kepala' => 'Sekretaris DPRD', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'INSP', 'nama' => 'INSPEKTORAT', 'nama_kepala' => 'Inspektur', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BAPPERIDA', 'nama' => 'BADAN PERENCANAAN PEMBANGUNAN, RISET DAN INOVASI DAERAH', 'nama_kepala' => 'Kepala Bapperida', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BPKAD', 'nama' => 'BADAN PENGELOLAAN KEUANGAN DAN ASET DAERAH', 'nama_kepala' => 'Kepala BPKAD', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BPPRD', 'nama' => 'BADAN PENGELOLAAN PAJAK DAN RETRIBUSI DAERAH', 'nama_kepala' => 'Kepala BPPRD', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BKPSDM', 'nama' => 'BADAN KEPEGAWAIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA', 'nama_kepala' => 'Kepala BKPSDM', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISDIK', 'nama' => 'DINAS PENDIDIKAN', 'nama_kepala' => 'Kepala Dinas Pendidikan', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DINKES', 'nama' => 'DINAS KESEHATAN', 'nama_kepala' => 'Kepala Dinas Kesehatan', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DPUPR', 'nama' => 'DINAS PEKERJAAN UMUM DAN PENATAAN RUANG', 'nama_kepala' => 'Kepala DPUPR', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISPERKIM', 'nama' => 'DINAS PERUMAHAN DAN PERMUKIMAN', 'nama_kepala' => 'Kepala Disperkim', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DINSOS', 'nama' => 'DINAS SOSIAL', 'nama_kepala' => 'Kepala Dinas Sosial', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISKOPUKM', 'nama' => 'DINAS KOPERASI, USAHA MIKRO DAN TENAGA KERJA', 'nama_kepala' => 'Kepala Diskopukm', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISHUB', 'nama' => 'DINAS PERHUBUNGAN', 'nama_kepala' => 'Kepala Dishub', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISKOMINFO', 'nama' => 'DINAS KOMUNIKASI DAN INFORMATIKA', 'nama_kepala' => 'Kepala Diskominfo', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISPORA', 'nama' => 'DINAS PEMUDA OLAHRAGA, KEBUDAYAAN DAN PARIWISATA', 'nama_kepala' => 'Kepala Dispora', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISPERINDAG', 'nama' => 'DINAS PERDAGANGAN DAN PERINDUSTRIAN', 'nama_kepala' => 'Kepala Disperindag', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DKPP', 'nama' => 'DINAS KETAHANAN PANGAN, PERTANIAN DAN PERIKANAN', 'nama_kepala' => 'Kepala DKPP', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DUKCAPIL', 'nama' => 'DINAS KEPENDUDUKAN DAN CATATAN SIPIL', 'nama_kepala' => 'Kepala Dukcapil', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DP3AKB', 'nama' => 'DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK, PEMBERDAYAAN MASYARAKAT, PENGENDALIAN PENDUDUK DAN KELUARGA BERENCANA', 'nama_kepala' => 'Kepala DP3AKB', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DLH', 'nama' => 'DINAS LINGKUNGAN HIDUP', 'nama_kepala' => 'Kepala DLH', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DPMPTSP', 'nama' => 'DINAS PENANAMAN MODAL DAN PELAYANAN TERPADU SATU PINTU', 'nama_kepala' => 'Kepala DPMPTSP', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'DISPUSIP', 'nama' => 'DINAS ARSIP DAN PERPUSTAKAAN DAERAH', 'nama_kepala' => 'Kepala Dispusip', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'SATPOLPP', 'nama' => 'SATUAN POLISI PAMONG PRAJA', 'nama_kepala' => 'Kepala Satpol PP', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BANKESBANGPOL', 'nama' => 'BADAN KESATUAN BANGSA DAN POLITIK', 'nama_kepala' => 'Kepala Bankesbangpol', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'BPBD', 'nama' => 'BADAN PENANGGULANGAN BENCANA DAERAH', 'nama_kepala' => 'Kepala BPBD', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'RSD', 'nama' => 'RUMAH SAKIT DAERAH IDAMAN', 'nama_kepala' => 'Direktur RSD Idaman', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'KEC-LA', 'nama' => 'KECAMATAN LIANG ANGGANG', 'nama_kepala' => 'Camat Liang Anggang', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'KEC-LU', 'nama' => 'KECAMATAN LANDASAN ULIN', 'nama_kepala' => 'Camat Landasan Ulin', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'KEC-CP', 'nama' => 'KECAMATAN CEMPAKA', 'nama_kepala' => 'Camat Cempaka', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'KEC-BU', 'nama' => 'KECAMATAN BANJARBARU UTARA', 'nama_kepala' => 'Camat Banjarbaru Utara', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
            ['kode' => 'KEC-BS', 'nama' => 'KECAMATAN BANJARBARU SELATAN', 'nama_kepala' => 'Camat Banjarbaru Selatan', 'status' => 'AKTIF', 'dibuat_pada' => date('Y-m-d H:i:s')],
        ];

        $this->db->table('perangkat_daerah')->insertBatch($data);
    }
}