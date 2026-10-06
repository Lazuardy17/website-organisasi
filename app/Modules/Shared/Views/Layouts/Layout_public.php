<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Penilaian Kematangan Perangkat Daerah — Kota Banjarbaru' ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/global.css') ?>" rel="stylesheet">

    <style>
        :root {
            --navy: #013D58;
            --navy-dark: #012f46;
            --gold: #F7C741;
            --soft-gray: #F5F5F5;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #fff;
            font-family: 'Poppins', 'Segoe UI', Tahoma, sans-serif;
            color: #111;
            margin: 0;
        }

        /* ===== Navbar ===== */
        .site-navbar {
            background: #fff;
            padding: 16px 0;
        }

        .site-navbar .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0;
        }

        .site-navbar .brand-logo {
            height: 56px;
            width: auto;
            display: block;
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.15));
        }

        .site-navbar .brand-text {
            font-size: 0.95rem;
            line-height: 1.2;
            color: #000;
            font-weight: 400;
        }

        .site-navbar .nav-link {
            color: #111;
            font-size: 0.95rem;
            font-weight: 400;
            padding: 0.4rem 0.8rem;
        }

        .site-navbar .nav-link:hover {
            color: var(--navy);
        }

        .btn-masuk {
            border: 1px solid var(--gold);
            background: #fff;
            color: #111;
            font-size: 0.95rem;
            font-weight: 400;
            padding: 6px 26px;
            border-radius: 10px;
            transition: all 0.2s ease;
        }

        .btn-masuk:hover {
            background: var(--gold);
            color: #111;
        }

        /* ===== Hero ===== */
        .hero {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            min-height: 430px;
            display: flex;
            align-items: center;
            background-color: var(--navy);
            background-image:
                linear-gradient(to right,
                    rgba(25, 64, 136, 0.55) 0%,
                    rgba(25, 64, 136, 0.25) 45%,
                    rgba(1, 60, 90, 0.05) 100%),
                url('<?= base_url('assets/img/hero-kantor.jpg') ?>');
            background-size: cover, cover;
            background-position: center, center;
            background-repeat: no-repeat, no-repeat;
        }

        .hero-title {
            position: relative;
            color: #fff;
            font-weight: 600;
            font-size: clamp(2rem, 5vw, 3.2rem);
            line-height: 1.15;
            padding-left: clamp(1.5rem, 4vw, 3rem);
            max-width: 640px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.35);
            z-index: 2;
        }

        /* ===== Info card ===== */
        .info-card {
            border-radius: 40px;
            overflow: hidden;
            background: var(--soft-gray);
        }

        .info-text {
            padding: 45px 55px;
            font-size: 1rem;
            line-height: 2.2;
            color: #111;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .info-logo {
            background-color: var(--navy);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            min-height: 260px;
            height: 100%;
        }

        .info-logo img {
            max-width: 240px;
            width: 100%;
            filter: drop-shadow(0 4px 4px rgba(0, 0, 0, 0.35));
        }

        /* ===== Login (dipakai di dalam info-card) ===== */
        .login-form-side {
            padding: 45px 55px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-form-side h3 {
            color: var(--navy);
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-size: 1.4rem;
        }

        .login-form-side .form-label {
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 6px;
        }

        .login-form-side .form-control {
            border: 1px solid var(--gold);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.9rem;
            background: #fff;
            transition: border-color 0.2s ease;
        }

        .login-form-side .form-control:focus {
            border-color: var(--navy-dark);
            box-shadow: none;
            outline: none;
        }

        /* Input dengan ikon toggle password */
        .input-with-icon {
            position: relative;
        }

        .input-with-icon .form-control {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 4px;
            display: flex;
            align-items: center;
            opacity: 0.6;
        }

        .toggle-password:hover {
            opacity: 1;
        }

        .toggle-password.aktif svg {
            stroke: #dc2626;
        }

        .btn-login {
            background-color: var(--navy);
            border: none;
            color: #fff;
            padding: 10px 40px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-login:hover {
            background-color: var(--navy-dark);
            color: #fff;
        }
    </style>
</head>

<body>

    <?php if (empty($hideChrome)): ?>
        <?= $this->include('App\Modules\Shared\Views\Components\topbar') ?>
        <?= $this->include('App\Modules\Shared\Views\Components\navbar') ?>
    <?php endif; ?>

    <?= $this->renderSection('content') ?>

    <?php if (empty($hideChrome)): ?>
        <?= $this->include('App\Modules\Shared\Views\Components\footer') ?>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JS Toggle Tentang <-> Login + Toggle Password -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navBeranda = document.getElementById('nav-beranda');
            const navTentang = document.getElementById('nav-tentang');
            const navMasuk = document.getElementById('nav-masuk');
            const tentangView = document.getElementById('tentang-view');
            const loginView = document.getElementById('login-view');

            // Kalau bukan di halaman landing, keluar (biar tidak error)
            if (!tentangView || !loginView) return;

            function showTentang() {
                tentangView.style.display = 'contents';
                loginView.style.display = 'none';
            }

            function showLogin() {
                tentangView.style.display = 'none';
                loginView.style.display = 'contents';
            }

            // ⭐ AUTO-SHOW LOGIN — kalau ada flashdata error dari controller
            <?php if (session()->getFlashdata('error')): ?>
                showLogin();
                window.addEventListener('load', function() {
                    document.getElementById('switch-area').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            <?php endif; ?>

            if (navBeranda) {
                navBeranda.addEventListener('click', function(e) {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            }

            if (navTentang) {
                navTentang.addEventListener('click', function(e) {
                    e.preventDefault();
                    showTentang();
                    setTimeout(function() {
                        document.getElementById('switch-area').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 50);
                });
            }

            if (navMasuk) {
                navMasuk.addEventListener('click', function(e) {
                    e.preventDefault();
                    showLogin();
                    setTimeout(function() {
                        document.getElementById('switch-area').scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }, 50);
                });
            }
        });

        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                button.classList.add('aktif');
                button.title = 'Sembunyikan password';
            } else {
                input.type = 'password';
                button.classList.remove('aktif');
                button.title = 'Lihat password';
            }
        }
    </script>
</body>

</html>