<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

<h1>Dashboard OPD</h1>
<p class="subtitle">Selamat datang, <strong><?= esc($opd['nama']) ?></strong>!</p>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-info"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (!empty($catatan_admin)): ?>
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle" style="margin-right: 8px;"></i> <strong>Ada catatan revisi dari Admin:</strong> Silakan perbaiki penilaian Anda.<br>
        <a href="<?= base_url('/opd/penilaian') ?>" style="color: #92400e; font-weight: 700;">
            Lihat & perbaiki sekarang <i class="bi bi-arrow-right"></i>
        </a>
    </div>
<?php endif; ?>

<?php if (!$periode): ?>
    <div class="alert alert-error">Belum ada periode penilaian yang aktif. Hubungi Admin.</div>
<?php else: ?>

    <!-- Statistik -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="label">Total Variabel</div>
            <div class="value"><?= $total_variabel ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Belum Diisi</div>
            <div class="value"><?= $belum_diisi ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Status</div>
            <div class="value" style="font-size: 20px;"><?= esc($status) ?></div>
        </div>
        <div class="stat-card">
            <div class="label">Skor</div>
            <div class="value"><?= $skor !== null ? number_format($skor, 0) : '—' ?></div>
        </div>
    </div>

    <!-- Progress Pengisian -->
    <div class="card card-wide">
        <h2>Progress Pengisian Variabel</h2>
        <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
            <span style="color: #6b7280;">Variabel yang sudah diisi</span>
            <strong style="color: var(--navy);"><?= $terisi ?>/<?= $total_variabel ?></strong>
        </div>
        <div style="background: #e5e7eb; height: 10px; border-radius: 5px; overflow: hidden; margin-bottom: 20px;">
            <div style="background: var(--navy); height: 100%; width: <?= ($terisi / $total_variabel) * 100 ?>%;"></div>
        </div>

        <?php if ($terisi < 11): ?>
            <a href="<?= base_url('/opd/penilaian') ?>" class="btn btn-primary">Lanjutkan Pengisian <i class="bi bi-arrow-right"></i></a>
        <?php else: ?>
            <a href="<?= base_url('/opd/kesimpulan') ?>" class="btn btn-primary">Lihat Kesimpulan <i class="bi bi-arrow-right"></i></a>
        <?php endif; ?>
    </div>

    <!-- Status Pengerjaan -->
    <div class="card card-wide">
        <h2>Status Pengerjaan</h2>
        <div class="steps">
            <?php
                $tahap1 = ($terisi > 0) ? 'selesai' : 'aktif';
                $tahap2 = ($terisi >= 11) ? 'selesai' : (($terisi > 0) ? 'aktif' : '');
                $tahap3 = (in_array($status, ['DIKIRIM', 'PERLU_VERIFIKASI_ULANG', 'TERVERIFIKASI'])) ? 'selesai' : (($terisi >= 11) ? 'aktif' : '');
                $tahap4 = ($status === 'TERVERIFIKASI') ? 'selesai' : (($status === 'DIKIRIM') ? 'aktif' : '');
            ?>
            <div class="step <?= $tahap1 ?>">
                <div class="circle">1</div>
                <div class="title">Pengisian</div>
                <div class="desc">Isi seluruh variabel penilaian</div>
            </div>
            <div class="step <?= $tahap2 ?>">
                <div class="circle">2</div>
                <div class="title">Kalkulasi</div>
                <div class="desc">Sistem menghitung skor</div>
            </div>
            <div class="step <?= $tahap3 ?>">
                <div class="circle">3</div>
                <div class="title">Verifikasi</div>
                <div class="desc">Menunggu verifikasi Admin</div>
            </div>
            <div class="step <?= $tahap4 ?>">
                <div class="circle">4</div>
                <div class="title">Selesai</div>
                <div class="desc">Nilai akhir sudah fix</div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?= $this->endSection() ?>