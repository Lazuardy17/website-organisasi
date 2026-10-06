<!-- Navbar -->
<nav class="navbar navbar-expand-md site-navbar">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
            <img src="<?= base_url('assets/img/logo-banjarbaru.png') ?>"
                 alt="Logo Banjarbaru" class="brand-logo">
            <span class="brand-text">Pemerintah<br>Kota Banjarbaru</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navMenu">
            <ul class="navbar-nav align-items-md-center gap-md-1">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/') ?>" id="nav-beranda">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="nav-tentang">Tentang Penilaian</a>
                </li>
                <li class="nav-item ms-md-3">
                    <a class="btn btn-masuk" href="#" id="nav-masuk">Masuk</a>
                </li>
            </ul>
        </div>
    </div>
</nav>