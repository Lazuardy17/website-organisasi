<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_public') ?>

<?= $this->section('content') ?>

<div class="container mt-4 mb-5">

    <!-- Hero -->
    <section class="hero mb-4">
        <h1 class="hero-title">
            Penilaian<br>
            Kematangan<br>
            Perangkat Daerah
        </h1>
    </section>

    <!-- ============ SWITCH AREA ============ -->
    <section class="info-card row g-0" id="switch-area">

        <!-- VIEW 1: Tentang (default) -->
        <div id="tentang-view" class="row g-0 w-100 m-0">
            <div class="col-md-7">
                <div class="info-text">
                    Menurut Permendagri Nomor 99 Tahun 2018 tentang Pembinaan dan Pengendalian
                    Penataan Perangkat Daerah, penilaian kematangan perangkat daerah merupakan
                    instrumen untuk melihat sejauh mana perangkat daerah mampu melaksanakan
                    tugas dan fungsinya secara efektif, efisien, dan berkelanjutan.
                </div>
            </div>
            <div class="col-md-5">
                <div class="info-logo h-100">
                    <img src="<?= base_url('assets/img/logo-banjarbaru.png') ?>"
                         alt="Lambang Kota Banjarbaru">
                </div>
            </div>
        </div>

        <!-- VIEW 2: Login (hidden default) -->
        <div id="login-view" class="row g-0 w-100 m-0" style="display: none;">
            <div class="col-md-7">
                <div class="login-form-side">
                    <h3>Masuk Akun</h3>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('/login/attempt') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username"
                                   class="form-control" placeholder="Masukkan Username"
                                   required>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-with-icon">
                                <input type="password" name="password" id="password"
                                       class="form-control" placeholder="Masukkan Password"
                                       required>
                                <button type="button" class="toggle-password"
                                        onclick="togglePassword('password', this)"
                                        title="Lihat password">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                         viewBox="0 0 24 24" fill="none" stroke="#0d3b66"
                                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-login">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="info-logo h-100">
                    <img src="<?= base_url('assets/img/logo-banjarbaru.png') ?>"
                         alt="Lambang Kota Banjarbaru">
                </div>
            </div>
        </div>

    </section>

</div>

<?= $this->endSection() ?>