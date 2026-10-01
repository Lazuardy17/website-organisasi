<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TingkatSeeder extends Seeder
{
    public function run()
    {
        $variabelIds = $this->db->table('variabel_penilaian')
            ->orderBy('nomor_urutan', 'ASC')
            ->get()->getResultArray();

        $data = [];

        $indikators = [
            1 => [
                1 => [
                    'indikator' => 'Penentuan kegiatan yang diprioritaskan dalam dokumen perencanaan tahunan (Renja/RKPD) dilakukan tanpa ada kriteria yang terukur.',
                    'verifikasi' => 'Tidak ada dokumen analisis kriteria untuk menentukan prioritas.',
                ],
                2 => [
                    'indikator' => 'Penentuan kegiatan yang diprioritaskan dalam dokumen rencana tahunan dilakukan berdasarkan analisis terhadap hasil (outcome) apa yang akan dicapai kegiatan tersebut.',
                    'verifikasi' => 'Ada TOR setiap usulan kegiatan dan di dalam TOR tersebut ada analisis outcome yang ingin dicapai.',
                ],
                3 => [
                    'indikator' => 'Penentuan prioritas kegiatan dalam dokumen rencana tahunan dilakukan berdasarkan analisis hasil (outcome) dan analisis kemampuan kegiatan menghasilkan hasil (outcome).',
                    'verifikasi' => 'Ada TOR setiap usulan kegiatan dan ada analisis yang menjelaskan alur logika bahwa kegiatan tersebut mampu menghasilkan outcome yang ditargetkan.',
                ],
                4 => [
                    'indikator' => 'Penentuan prioritas kegiatan dilakukan berdasarkan analisis yang membandingkan hasil (outcome) yang akan dicapai antara satu alternatif kegiatan dengan alternatif kegiatan yang lain.',
                    'verifikasi' => 'Ada TOR setiap kegiatan dan ada dokumen yang berisi metode analisis tertentu (misalnya metode USG) yang membandingkan keunggulan setiap kegiatan dalam menentukan kegiatan yang menjadi prioritas.',
                ],
                5 => [
                    'indikator' => 'Penentuan prioritas kegiatan dalam dokumen tahunan dilakukan dengan perbandingan hasil (outcome) antara satu alternatif kegiatan dengan alternatif kegiatan yang lain dan dibantu dengan teknologi informasi.',
                    'verifikasi' => 'Cek apakah kegiatan pada level IV sudah dilakukan dan apakah ada bantuan teknologi IT dalam proses penentuan prioritas dan perencanaan.',
                ],
            ],
            2 => [
                1 => [
                    'indikator' => 'Monitoring dan pengendalian dilakukan dengan cara sederhana dan tidak terstruktur.',
                    'verifikasi' => 'Ada kegiatan monev yang dilakukan.',
                ],
                2 => [
                    'indikator' => 'Monitoring dan pengendalian dilakukan secara berkala dengan fokus yang ditentukan.',
                    'verifikasi' => 'PD dianggap ada pada level ini jika sudah ada dokumen monev yang sudah mempunyai objek yang akan dimonev, fokus dan kriteria terukur, dan jadwal yang jelas.',
                ],
                3 => [
                    'indikator' => 'Monitoring dan pengendalian dilakukan secara berkala dengan kriteria penyimpangan yang terstandarisasi pada setiap tahap kegiatan.',
                    'verifikasi' => 'Cek apakah PD sudah mempunyai standar penilaian dan kriteria penilaian terhadap objek yang dimonev. Jika belum, maka PD belum dapat dianggap ada pada level ini.',
                ],
                4 => [
                    'indikator' => 'Monitoring dan pengendalian dilakukan secara berkala dengan kriteria penyimpangan yang terstandarisasi dan diikuti dengan umpan balik berupa perbaikan yang terdokumentasi dengan baik.',
                    'verifikasi' => 'Cek apakah PD sudah mempunyai standar penilaian dan kriteria penilaian terhadap objek yang dimonev serta ada dokumen hasil pembahasan atas hasil monev beserta tindak lanjut yang harus dilakukan.',
                ],
                5 => [
                    'indikator' => 'Monitoring dan pengendalian dilakukan secara sistematis, terstandarisasi termasuk umpan balik yang didukung oleh penggunaan teknologi informasi berbasis internet.',
                    'verifikasi' => 'Cek apakah kegiatan pada level IV sudah dilakukan serta monev dan tindak lanjut hasil monev sudah dilakukan dengan bantuan IT.',
                ],
            ],
            3 => [
                1 => [
                    'indikator' => 'Tidak ada penjaminan mutu atas produk yang dihasilkan dan atas proses kerja yang dilakukan.',
                    'verifikasi' => 'Cek apakah ada kegiatan untuk pemeriksaan mutu produk dan proses kerja.',
                ],
                2 => [
                    'indikator' => 'Penjaminan mutu produk dan proses kerja dilakukan secara berkala namun tidak mempunyai standar mutu produk dan proses yang ditetapkan.',
                    'verifikasi' => 'Sudah ada pemeriksaan mutu output dan proses yang ditunjukkan dengan dokumen pengujian mutu.',
                ],
                3 => [
                    'indikator' => 'Mutu produk dan proses sudah distandarisasi dan dilakukan pengujian secara berkala secara internal.',
                    'verifikasi' => 'Sudah ada dokumen standar output/produk dan standar proses kerja (SOP). Serta sudah ada dokumen pengujian mutu oleh petugas internal PD.',
                ],
                4 => [
                    'indikator' => 'Penjaminan mutu produk dan proses sudah distandarisasi serta dilakukan pengukuran/pengujian secara berkala oleh tenaga yang bersertifikat.',
                    'verifikasi' => 'Sudah ada dokumen standar output/produk dan standar proses kerja (SOP). Serta sudah ada dokumen pengujian mutu oleh petugas di luar PD yang mempunyai sertifikat ahli.',
                ],
                5 => [
                    'indikator' => 'Penjaminan mutu produk dan proses dilakukan terstandarisasi dan berkala oleh tenaga ahli bersertifikat serta didukung oleh teknologi informasi berbasis internet.',
                    'verifikasi' => 'Cek apakah kegiatan pada level IV sudah dilakukan dan penjaminan mutu dilakukan dengan bantuan IT.',
                ],
            ],
            4 => [
                1 => [
                    'indikator' => 'Tidak ada definisi resmi proses pelaksanaan pekerjaan pada perangkat daerah.',
                    'verifikasi' => 'Tidak ada penjelasan tentang tahapan pelaksanaan suatu pekerjaan.',
                ],
                2 => [
                    'indikator' => 'Definisi proses organisasi sudah dituangkan dalam standar operasi prosedur (SOP).',
                    'verifikasi' => 'Sudah ada tahapan pelaksanaan pekerjaan dan sudah dituangkan dalam dokumen SOP (rapat, perjalanan dinas, pencairan uang, penerimaan barang, surat masuk/keluar, dll).',
                ],
                3 => [
                    'indikator' => 'Definisi proses organisasi sudah dituangkan ke dalam SOP dan telah dilakukan evaluasi berkala terhadap penerapan SOP.',
                    'verifikasi' => 'Cek dokumen pada level II dan cek pula apakah ada dokumen evaluasi berkala (tahunan/bulanan) atas pelaksanaan SOP tersebut.',
                ],
                4 => [
                    'indikator' => 'Definisi proses organisasi sudah dituangkan dalam SOP, sudah dievaluasi secara berkala dan dilakukan tindak lanjut terhadap hasil evaluasi penerapan SOP berupa tindakan koreksi atau perbaikan SOP.',
                    'verifikasi' => 'Cek dokumen pada level III dan cek pula apakah ada dokumen evaluasi berkala serta apakah ada bukti tindak lanjut dari hasil evaluasi SOP tersebut.',
                ],
                5 => [
                    'indikator' => 'Definisi proses organisasi sudah dituangkan dalam SOP dan sudah dilakukan evaluasi serta tindak lanjut, kemudian disesuaikan dengan kebutuhan/keluhan pelanggan serta didukung oleh teknologi berbasis internet.',
                    'verifikasi' => 'Cek apakah kegiatan pada level IV sudah dilakukan dan pelaksanaan SOP dan evaluasinya sudah dilakukan dengan bantuan IT.',
                ],
            ],
            5 => [
                1 => [
                    'indikator' => 'Belum ada dokumen resmi rencana kebutuhan pendidikan dan pelatihan pada perangkat daerah yang bersangkutan.',
                    'verifikasi' => 'Cek apakah sudah ada dokumen rencana pengembangan pegawai pada setiap PD. Jika belum berarti PD tersebut ada pada level ini.',
                ],
                2 => [
                    'indikator' => 'Dokumen rencana kebutuhan pengembangan pegawai sudah tersusun secara parsial untuk jabatan tertentu.',
                    'verifikasi' => 'Jika dokumen rencana pengembangan pegawai baru ada untuk jabatan tertentu, maka PD tersebut berada pada level ini.',
                ],
                3 => [
                    'indikator' => 'Dokumen rencana kebutuhan pengembangan pegawai disusun untuk seluruh jabatan.',
                    'verifikasi' => 'Jika dokumen rencana pengembangan pegawai sudah ada untuk semua jabatan (JPT, Fungsional dan Administrasi), maka PD tersebut berada pada level ini.',
                ],
                4 => [
                    'indikator' => 'Rencana pengembangan pegawai dievaluasi secara regular dan seluruh pengembangan pegawai sudah dilaksanakan sesuai dengan dokumen rencana pengembangan pegawai yang sudah ditetapkan.',
                    'verifikasi' => 'Cek apakah rencana pengembangan sudah dilaksanakan dan apakah sudah ada dokumen evaluasi rencana pengembangan pegawai.',
                ],
                5 => [
                    'indikator' => 'Hasil (outcome) pengembangan pegawai dievaluasi secara regular sebagai umpan balik.',
                    'verifikasi' => 'Cek apakah ada dokumen evaluasi outcome dari pengembangan pegawai yang dilakukan dan umpan balik yang dilakukan.',
                ],
            ],
            6 => [
                1 => [
                    'indikator' => 'Analisis kebijakan dan pemecahan masalah dilakukan secara sederhana dan dengan metode yang tidak terukur.',
                    'verifikasi' => 'Tidak ada dokumen penerapan mekanisme dan metode pemecahan masalah dan analisis kebijakan pada PD.',
                ],
                2 => [
                    'indikator' => 'Analisis kebijakan yang berdampak ke publik dilakukan oleh tim internal perangkat daerah yang bersangkutan.',
                    'verifikasi' => 'Sudah ada dokumen yang menunjukkan adanya penerapan mekanisme dan metode pemecahan masalah yang dilakukan oleh internal PD.',
                ],
                3 => [
                    'indikator' => 'Analisis kebijakan dan pemecahan masalah yang berdampak ke publik dilakukan menggunakan metode/teknik ilmiah oleh tim internal dengan melibatkan instansi pemerintah terkait.',
                    'verifikasi' => 'Sudah ada dokumen yang menunjukkan adanya penerapan mekanisme dan metode ilmiah dalam memecahkan masalah publik dengan melibatkan pihak luar pada PD.',
                ],
                4 => [
                    'indikator' => 'Analisis kebijakan dan pemecahan masalah yang bersifat strategis/berdampak ke publik melibatkan tim ahli.',
                    'verifikasi' => 'Adanya dokumen yang menunjukkan pemecahan masalah publik yang berdampak luas kepada masyarakat dilakukan dengan melibatkan ahli.',
                ],
                5 => [
                    'indikator' => 'Analisis kebijakan dan pemecahan masalah strategis/berdampak ke publik melibatkan tim ahli dengan melakukan konsultasi publik dan analisis umpan balik yang terukur dan terdokumentasi.',
                    'verifikasi' => 'Kegiatan pada level IV sudah dilaksanakan, ditambah dengan adanya dokumen yang menunjukkan dilakukannya konsultasi publik.',
                ],
            ],
            7 => [
                1 => [
                    'indikator' => 'Penggunaan sumber daya dilakukan hanya berdasarkan ketentuan formal yang berlaku.',
                    'verifikasi' => 'Belum ada dokumen analisis kebutuhan sumber daya setiap fungsi/kegiatan.',
                ],
                2 => [
                    'indikator' => 'Penentuan penggunaan input proyek dilakukan berdasarkan analisis kebutuhan bahan/sumber daya yang sudah ditetapkan.',
                    'verifikasi' => 'Sudah ada dokumen Standar analisis biaya setiap kegiatan.',
                ],
                3 => [
                    'indikator' => 'Analisis kebutuhan input/sumber daya proyek sudah distandarisasi dengan proses ujicoba secara terbuka dan menggunakan metode ilmiah.',
                    'verifikasi' => 'Ada dokumen SAB dan Dokumen Uji Coba Standar.',
                ],
                4 => [
                    'indikator' => 'Penyediaan sumber daya dalam pelaksanaan proyek dimonitor secara ketat berdasarkan standar input sumber daya, SOP dan prosedur penjaminan mutu produk.',
                    'verifikasi' => 'Ada dokumen evaluasi dan monitoring penggunaan sumber daya.',
                ],
                5 => [
                    'indikator' => 'Penyediaan sumber daya dan pelaksanaan proyek dimonitor secara ketat berdasarkan SOP dan prosedur penjaminan mutu produk dan didukung oleh teknologi informasi berbasis internet.',
                    'verifikasi' => 'Ada integrasi evaluasi penggunaan sumber daya dengan teknologi informasi.',
                ],
            ],
            8 => [
                1 => [
                    'indikator' => 'Belum ada manajemen resiko dalam pelaksanaan tugas pada perangkat daerah.',
                    'verifikasi' => 'Belum ada dokumen tentang manajemen resiko pada PD yang bersangkutan.',
                ],
                2 => [
                    'indikator' => 'Sudah ada sebagian pegawai yang melakukan analisis resiko dalam pelaksanaan tugasnya, namun hanya bersifat individu.',
                    'verifikasi' => 'Beberapa pegawai secara individu sudah mempunyai dokumen manajemen resiko.',
                ],
                3 => [
                    'indikator' => 'Perangkat daerah sudah menetapkan prosedur pengelolaan resiko dalam pelaksanaan tugas tertentu yang dipandang mempunyai resiko tinggi.',
                    'verifikasi' => 'Sudah ada dokumen manajemen resiko yang ditetapkan pada PD yang bersangkutan.',
                ],
                4 => [
                    'indikator' => 'Perangkat daerah sudah menetapkan prosedur pengelolaan resiko untuk seluruh tugas pada perangkat daerah yang bersangkutan, namun belum dilakukan evaluasi secara berkala.',
                    'verifikasi' => 'Sudah ada dokumen manajemen resiko yang ditetapkan dan sudah ada dokumen evaluasi konsisten penerapannya dalam pelaksanaan tugas.',
                ],
                5 => [
                    'indikator' => 'Perangkat Daerah sudah menetapkan prosedur pengelolaan resiko dalam pelaksanaan tugas serta semua resiko dapat dikendalikan tanpa ada kerugian baik bagi pegawai maupun instansi.',
                    'verifikasi' => 'Bukti pada level IV sudah tersedia, dan semua resiko dapat dikendalikan sehingga tidak ada kerugian fisik, materi maupun kerugian lainnya pada PD.',
                ],
            ],
            9 => [
                1 => [
                    'indikator' => 'Belum ada target/rencana kinerja perangkat daerah yang terukur.',
                    'verifikasi' => 'Belum ada dokumen yang memuat rencana kinerja pemerintah daerah yang terukur.',
                ],
                2 => [
                    'indikator' => 'Sudah ada target kinerja perangkat daerah, tapi belum konsisten mengacu dokumen perencanaan daerah.',
                    'verifikasi' => 'Sudah ada dokumen yang berisi target kinerja (perjanjian kinerja), namun belum sama dengan indikator dalam dokumen perencanaan.',
                ],
                3 => [
                    'indikator' => 'Sudah ada target kinerja perangkat daerah yang konsisten dengan dokumen perencanaan.',
                    'verifikasi' => 'Sudah ada dokumen yang berisi target kinerja dengan indikator yang sama dalam dokumen perencanaan (renstra/renja).',
                ],
                4 => [
                    'indikator' => 'Target kinerja perangkat daerah sudah dilakukan pengukuran pencapaiannya.',
                    'verifikasi' => 'Sudah ada dokumen pengukuran pencapaian target kinerja perangkat daerah sesuai dengan rencana kinerja.',
                ],
                5 => [
                    'indikator' => 'Pencapaian target kinerja perangkat daerah sudah diukur dan sudah tercapai dengan baik (diatas 90%) serta telah dilakukan evaluasi pencapaian target kinerja serta didukung dengan teknologi informasi.',
                    'verifikasi' => 'Sudah ada dokumen target kinerja yang sesuai dengan dokumen perencanaan dan sudah dilakukan pengukuran dengan tingkat pencapaian di atas 90%.',
                ],
            ],
            10 => [
                1 => [
                    'indikator' => 'Belum ada rencana pengembangan produk yang akan dilakukan secara sistematis.',
                    'verifikasi' => 'Belum ada dokumen rencana inovasi pelayanan pada PD yang bersangkutan.',
                ],
                2 => [
                    'indikator' => 'Pengembangan produk dilakukan dengan mengadopsi inovasi yang dikembangkan oleh daerah lain (replikasi inovasi).',
                    'verifikasi' => 'Sudah ada dokumen yang menunjukkan adanya inovasi baru dalam pelayanan, namun hanya berupa replikasi dari daerah/instansi lain.',
                ],
                3 => [
                    'indikator' => 'Telah disusun rencana pengembangan inovasi baik jenis, mutu maupun metodenya.',
                    'verifikasi' => 'Sudah ada dokumen rencana inovasi pada PD yang memuat objek, kerangka waktu, pelaksana uji coba, dll.',
                ],
                4 => [
                    'indikator' => 'Telah ada inovasi yang dikembangkan sendiri oleh perangkat daerah yang bersangkutan.',
                    'verifikasi' => 'Ada dokumen yang menunjukkan bahwa ada inovasi baru yang diterapkan pada PD yang bersangkutan.',
                ],
                5 => [
                    'indikator' => 'Perangkat daerah sudah mempunyai program pengkajian dan inovasi secara terencana dan berkelanjutan.',
                    'verifikasi' => 'Sudah ada dokumen pada level III dan Level IV serta adanya kegiatan penelitian/uji coba inovasi yang berkelanjutan.',
                ],
            ],
            11 => [
                1 => [
                    'indikator' => 'Belum ada budaya organisasi pada perangkat daerah.',
                    'verifikasi' => 'Belum ada dokumen penerapan nilai budaya tertentu pada PD yang bersangkutan.',
                ],
                2 => [
                    'indikator' => 'Sudah ada slogan-slogan yang menggambarkan nilai organisasi pada perangkat daerah yang bersangkutan.',
                    'verifikasi' => 'Sudah ada dokumen yang memuat slogan-slogan penerapan nilai budaya pada PD yang bersangkutan.',
                ],
                3 => [
                    'indikator' => 'Sudah ada dokumen budaya organisasi yang resmi menggambarkan nilai-nilai, sikap dan perilaku di perangkat daerah yang bersangkutan.',
                    'verifikasi' => 'Sudah ada dokumen budaya organisasi resmi yang memuat nilai-nilai budaya, sikap dan perilaku tertentu pada PD.',
                ],
                4 => [
                    'indikator' => 'Sudah ada program internalisasi budaya organisasi yang berkelanjutan berdasarkan dokumen resmi.',
                    'verifikasi' => 'Ada dokumen yang menunjukkan bahwa PD secara rutin melakukan kegiatan yang menanamkan nilai-nilai budaya sesuai dokumen budaya organisasi.',
                ],
                5 => [
                    'indikator' => 'Budaya organisasi sudah tercermin dalam sikap dan perilaku pegawai pada perangkat daerah yang bersangkutan berdasarkan hasil evaluasi secara rutin dan berkelanjutan.',
                    'verifikasi' => 'Bukti level IV sudah tersedia dan sudah ada bukti adanya evaluasi secara berkala atas penerapan nilai, sikap dan perilaku oleh pegawai.',
                ],
            ],
        ];

        foreach ($variabelIds as $v) {
            $urutan = $v['nomor_urutan'];
            for ($level = 1; $level <= 5; $level++) {
                $data[] = [
                    'variabel_id'      => $v['id'],
                    'nomor_tingkat'    => $level,
                    'nama_tingkat'     => 'Tingkat ' . ['I','II','III','IV','V'][$level - 1],
                    'indikator'        => $indikators[$urutan][$level]['indikator'],
                    'verifikasi_bukti' => $indikators[$urutan][$level]['verifikasi'],
                    'nilai'            => $level,
                    'aktif'            => true,
                    'dibuat_pada'      => date('Y-m-d H:i:s'),
                ];
            }
        }

        $this->db->table('tingkat_penilaian')->insertBatch($data);
    }
}