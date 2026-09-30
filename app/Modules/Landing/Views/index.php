<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Kematangan Perangkat Daerah - Kota Banjarbaru</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, sans-serif;
        }
        html {
            scroll-behavior: smooth;
        }
        body {
            color: #1f2937;
            background: #f9fafb;
        }

        /* Top Bar */
        .top-bar {
            background: #0d3b66;
            color: #fff;
            padding: 8px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
        }
        .top-bar .info {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .top-bar .info svg {
            width: 16px;
            height: 16px;
            fill: #fff;
        }

        /* Header */
        header {
            background: #fff;
            padding: 16px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-area img {
            width: 45px;
            height: 45px;
        }
        .logo-area strong {
            display: block;
            color: #0d3b66;
            font-size: 15px;
        }
        .logo-area span {
            display: block;
            color: #6b7280;
            font-size: 13px;
        }
        nav {
            display: flex;
            align-items: center;
            gap: 30px;
        }
        nav a {
            color: #1f2937;
            text-decoration: none;
            font-size: 14px;
            transition: color 0.2s;
            cursor: pointer;
        }
        nav a:hover {
            color: #0d3b66;
        }
        .btn-masuk {
            background: #fff;
            color: #0d3b66 !important;
            border: 1px solid #0d3b66;
            padding: 8px 24px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            text-decoration: none;
        }
        .btn-masuk:hover {
            background: #0d3b66;
            color: #fff !important;
        }

        /* Hero */
        .hero {
            position: relative;
            height: 400px;
            background: linear-gradient(rgba(13,59,102,0.4), rgba(13,59,102,0.5)),
                        url('https://upload.wikimedia.org/wikipedia/commons/thumb/9/9e/Kantor_Wali_Kota_Banjarbaru.jpg/1200px-Kantor_Wali_Kota_Banjarbaru.jpg') center/cover no-repeat;
            display: flex;
            align-items: center;
            padding: 0 60px;
        }
        .hero h1 {
            color: #fff;
            font-size: 48px;
            font-weight: 700;
            line-height: 1.2;
            text-shadow: 2px 2px 8px rgba(0,0,0,0.3);
            max-width: 600px;
        }

        /* ============ Bagian Switch (Tentang <-> Login) ============ */
        .switch-area {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 40px;
            padding: 60px;
            max-width: 1200px;
            margin: 0 auto;
            min-height: 380px;
        }

        /* View Tentang */
        .content-text {
            background: #f3f4f6;
            padding: 40px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            font-size: 16px;
            line-height: 1.8;
            color: #374151;
        }
        .content-logo {
            background: #0d3b66;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .content-logo img {
            max-width: 220px;
            width: 100%;
        }

        /* View Login */
        .login-text {
            background: #f3f4f6;
            padding: 40px;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-text h3 {
            color: #0d3b66;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 24px;
        }
        .login-text .form-label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            color: #0d3b66;
        }
        .login-text .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            margin-bottom: 16px;
            outline: none;
            background: #fff;
        }
        .login-text .form-control:focus {
            border-color: #0d3b66;
        }
        .login-text .btn-login {
            background: #0d3b66;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            margin-top: 8px;
        }
        .login-text .btn-login:hover {
            background: #145a8a;
        }
        .login-text .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        /* Icon toggle password */
        .input-with-icon {
            position: relative;
            margin-bottom: 16px;
        }
        .input-with-icon .form-control {
            padding-right: 45px;
            margin-bottom: 0;
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

        /* Footer */
        footer {
            background: #0d3b66;
            color: #fff;
            text-align: center;
            padding: 16px;
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .switch-area {
                grid-template-columns: 1fr;
                padding: 30px 20px;
            }
            header {
                flex-direction: column;
                gap: 12px;
                padding: 16px 20px;
            }
            .top-bar {
                flex-direction: column;
                gap: 4px;
                padding: 8px 20px;
                font-size: 12px;
                text-align: center;
            }
            nav {
                gap: 16px;
                font-size: 13px;
            }
            .hero {
                height: 280px;
                padding: 0 20px;
            }
            .hero h1 {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="info">
            <svg viewBox="0 0 24 24"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            <span>kelembagaan.kotabanjarbaru@gmail.com</span>
        </div>
        <div class="info">
            <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5a2.5 2.5 0 0 1 0-5 2.5 2.5 0 0 1 0 5z"/></svg>
            <span>Sekretariat Daerah Kota Banjarbaru Jl. Panglima Batur No. 1</span>
        </div>
    </div>

    <!-- Header -->
    <header>
        <div class="logo-area">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kota_Banjarbaru.png/200px-Lambang_Kota_Banjarbaru.png" alt="Logo Banjarbaru">
            <div>
                <strong>Pemerintah</strong>
                <span>Kota Banjarbaru</span>
            </div>
        </div>
        <nav>
            <a href="#beranda" id="nav-beranda">Beranda</a>
            <a href="#switch-area" id="nav-tentang">Tentang Penilaian</a>
            <a href="#switch-area" id="nav-masuk" class="btn-masuk">Masuk</a>
        </nav>
    </header>

    <!-- Hero -->
    <section class="hero" id="beranda">
        <h1>Penilaian<br>Kematangan<br>Perangkat Daerah</h1>
    </section>

    <!-- ============ Bagian Switch: Tentang <-> Login ============ -->
    <section class="switch-area" id="switch-area">

        <!-- View 1: Tentang (Default) -->
        <div id="tentang-view" style="display: contents;">
            <div class="content-text">
                <p>
                    Menurut Permendagri Nomor 99 Tahun 2018 tentang Pembinaan dan Pengendalian
                    Penataan Perangkat Daerah, penilaian kematangan perangkat daerah merupakan
                    instrumen untuk melihat sejauh mana perangkat daerah mampu melaksanakan
                    tugas dan fungsinya secara efektif, efisien, dan berkelanjutan.
                </p>
            </div>
            <div class="content-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kota_Banjarbaru.png/200px-Lambang_Kota_Banjarbaru.png" alt="Logo Banjarbaru">
            </div>
        </div>

        <!-- View 2: Login (Tersembunyi Default) -->
        <div id="login-view" style="display: none;">
            <div class="login-text">
                <h3>Masuk Akun</h3>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/login/attempt') ?>" method="post">
                    <?= csrf_field() ?>

                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan Username" required>

                    <label for="password" class="form-label">Password</label>
                    <div class="input-with-icon">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword('password', this)" title="Lihat password">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#0d3b66" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>

                    <button type="submit" class="btn-login">Masuk</button>
                </form>
            </div>
            <div class="content-logo">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kota_Banjarbaru.png/200px-Lambang_Kota_Banjarbaru.png" alt="Logo Banjarbaru">
            </div>
        </div>

    </section>

    <!-- Footer -->
    <footer>
        © <?= date('Y') ?> Pemerintah Kota Banjarbaru
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navBeranda  = document.getElementById('nav-beranda');
            const navTentang  = document.getElementById('nav-tentang');
            const navMasuk    = document.getElementById('nav-masuk');
            const tentangView = document.getElementById('tentang-view');
            const loginView   = document.getElementById('login-view');

            function showTentang() {
                tentangView.style.display = 'contents';
                loginView.style.display   = 'none';
            }

            function showLogin() {
                tentangView.style.display = 'none';
                loginView.style.display   = 'contents';
            }

            <?php if (session()->getFlashdata('error')): ?>
                showLogin();
                window.addEventListener('load', function () {
                    document.getElementById('switch-area').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            <?php endif; ?>

            navBeranda.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            navTentang.addEventListener('click', function (e) {
                e.preventDefault();
                showTentang();
                setTimeout(function () {
                    document.getElementById('switch-area').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 50);
            });

            navMasuk.addEventListener('click', function (e) {
                e.preventDefault();
                showLogin();
                setTimeout(function () {
                    document.getElementById('switch-area').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }, 50);
            });
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