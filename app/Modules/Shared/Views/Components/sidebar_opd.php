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
            <i class="bi bi-bar-chart"></i> Dashboard
        </a>

        <div class="section-title">Akun & Evaluasi</div>
        <a href="<?= base_url('/opd/akun') ?>"
           class="<?= (strpos($currentUrl, '/opd/akun') !== false) ? 'active' : '' ?>">
            <i class="bi bi-person"></i> Akun Saya
        </a>
        <a href="<?= base_url('/opd/penilaian') ?>"
           class="<?= (strpos($currentUrl, '/opd/penilaian') !== false) ? 'active' : '' ?>">
            <i class="bi bi-clipboard-check"></i> Pengisian Variabel
        </a>

        <div class="section-title">Pelaporan</div>
        <a href="<?= base_url('/opd/kesimpulan') ?>"
           class="<?= (strpos($currentUrl, '/opd/kesimpulan') !== false) ? 'active' : '' ?>">
            <i class="bi bi-file-check"></i> Kesimpulan & Submit
        </a>

        <div class="section-title">Pengaturan</div>
        <a href="<?= base_url('/ubah-password') ?>"
           class="<?= (strpos($currentUrl, '/ubah-password') !== false) ? 'active' : '' ?>">
            <i class="bi bi-lock"></i> Ubah Password
        </a>

    <?php else: ?>
        <!-- ==================== MENU TERKUNCI (belum isi identitas) ==================== -->

        <a href="<?= base_url('/opd/identitas') ?>" class="active">
            <i class="bi bi-card-text"></i> Isi Identitas
        </a>

        <div class="section-title">Terkunci</div>

        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-bar-chart"></i> Dashboard
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-person"></i> Akun Saya
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-clipboard-check"></i> Pengisian Variabel
        </a>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-file-check"></i> Kesimpulan & Submit
        </a>

        <div class="section-title">Pengaturan</div>
        <a href="#" class="disabled" title="Isi identitas terlebih dahulu">
            <i class="bi bi-lock"></i> Ubah Password
        </a>

    <?php endif; ?>

    <!-- Logout — selalu bisa diklik -->
    <a href="<?= base_url('/logout') ?>" class="logout">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</aside>