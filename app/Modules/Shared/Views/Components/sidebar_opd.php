<?php
$identitasLengkap = (bool) session()->get('identitas_lengkap');
$currentUrl = current_url();
?>

<!-- Sidebar OPD -->
<aside class="sidebar">
    <div class="brand">
        <img src="<?= base_url('assets/img/logo-banjarbaru.png') ?>" alt="Logo">
        <div>
            <strong>Pemerintah</strong>
            <span>Kota Banjarbaru</span>
        </div>
    </div>

    <?php if ($identitasLengkap): ?>
        <!-- ==================== MENU AKTIF (identitas sudah lengkap) ==================== -->

        <a href="<?= base_url('/opd/dashboard') ?>"
           class="<?= (strpos($currentUrl, '/opd/dashboard') !== false) ? 'active' : '' ?>">
            <i class="bi bi-bar-chart" style="margin-right: 8px;"></i> Dashboard
        </a>

        <div class="section-title">Akun & Evaluasi</div>
        <a href="<?= base_url('/opd/akun') ?>"
           class="<?= (strpos($currentUrl, '/opd/akun') !== false) ? 'active' : '' ?>">
            <i class="bi bi-person" style="margin-right: 8px;"></i> Akun Saya
        </a>
        <a href="<?= base_url('/opd/penilaian') ?>"
           class="<?= (strpos($currentUrl, '/opd/penilaian') !== false) ? 'active' : '' ?>">
            <i class="bi bi-clipboard-check" style="margin-right: 8px;"></i> Pengisian Variabel
        </a>

        <div class="section-title">Pelaporan</div>
        <a href="<?= base_url('/opd/kesimpulan') ?>"
           class="<?= (strpos($currentUrl, '/opd/kesimpulan') !== false) ? 'active' : '' ?>">
            <i class="bi bi-file-check" style="margin-right: 8px;"></i> Kesimpulan & Submit
        </a>
        <a href="<?= base_url('/opd/laporan') ?>"
           class="<?= (strpos($currentUrl, '/opd/laporan') !== false) ? 'active' : '' ?>">
            <i class="bi bi-file-earmark-pdf" style="margin-right: 8px;"></i> Ekspor Laporan
        </a>

        <div class="section-title">Pengaturan</div>
        <a href="<?= base_url('/ubah-password') ?>"
           class="<?= (strpos($currentUrl, '/ubah-password') !== false) ? 'active' : '' ?>">
            <i class="bi bi-lock" style="margin-right: 8px;"></i> Ubah Password
        </a>

    <?php else: ?>
        <!-- ==================== MENU TERKUNCI (belum isi identitas) ==================== -->

        <a href="<?= base_url('/opd/identitas') ?>" class="active">
            <i class="bi bi-card-text" style="margin-right: 8px;"></i> Isi Identitas
        </a>

        <div class="section-title">Terkunci</div>

        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-bar-chart" style="margin-right: 8px;"></i> Dashboard
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-person" style="margin-right: 8px;"></i> Akun Saya
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-clipboard-check" style="margin-right: 8px;"></i> Pengisian Variabel
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-file-check" style="margin-right: 8px;"></i> Kesimpulan & Submit
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-file-earmark-pdf" style="margin-right: 8px;"></i> Ekspor Laporan
        </a>

        <div class="section-title">Pengaturan</div>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-lock" style="margin-right: 8px;"></i> Ubah Password
        </a>

    <?php endif; ?>

    <!-- Logout — selalu bisa diklik -->
    <a href="<?= base_url('/logout') ?>" class="logout">
        <i class="bi bi-box-arrow-right" style="margin-right: 8px;"></i> Logout
    </a>
</aside>