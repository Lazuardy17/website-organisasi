<!-- Sidebar Admin -->
<aside class="sidebar">
    <div class="brand">
        <img src="<?= base_url('assets/img/logo-banjarbaru.png') ?>" alt="Logo">
        <div>
            <strong>Pemerintah</strong>
            <span>Kota Banjarbaru</span>
        </div>
    </div>

    <a href="<?= base_url('/admin/dashboard') ?>"
       class="<?= (current_url() == base_url('/admin/dashboard')) ? 'active' : '' ?>">
        <i class="bi bi-bar-chart" style="margin-right: 8px;"></i> Dashboard
    </a>

    <div class="section-title">Kelola User</div>
    <a href="<?= base_url('/admin/akun-opd') ?>"
       class="<?= (strpos(current_url(), '/admin/akun-opd') !== false) ? 'active' : '' ?>">
        <i class="bi bi-people" style="margin-right: 8px;"></i> Manajemen Akun OPD
    </a>

    <div class="section-title">Penilaian</div>
    <a href="<?= base_url('/admin/verifikasi') ?>"
       class="<?= (strpos(current_url(), '/admin/verifikasi') !== false) ? 'active' : '' ?>">
        <i class="bi bi-clipboard-check" style="margin-right: 8px;"></i> Verifikasi Penilaian
    </a>

    <div class="section-title">Pelaporan</div>
    <a href="<?= base_url('/admin/rekapitulasi') ?>"
       class="<?= (strpos(current_url(), '/admin/rekapitulasi') !== false) ? 'active' : '' ?>">
        <i class="bi bi-graph-up" style="margin-right: 8px;"></i> Rekapitulasi Data
    </a>
    <a href="<?= base_url('/admin/laporan') ?>"
       class="<?= (strpos(current_url(), '/admin/laporan') !== false) ? 'active' : '' ?>">
        <i class="bi bi-file-earmark-pdf" style="margin-right: 8px;"></i> Ekspor Laporan
    </a>

    <div class="section-title">Pengaturan</div>
    <a href="<?= base_url('/ubah-password') ?>"
       class="<?= (strpos(current_url(), '/ubah-password') !== false) ? 'active' : '' ?>">
        <i class="bi bi-lock" style="margin-right: 8px;"></i> Ubah Password
    </a>

   
        <a href="<?= base_url('/logout') ?>" class="logout">
            <i class="bi bi-box-arrow-right" style="margin-right: 8px;"></i> Logout
        </a>
    
</aside>