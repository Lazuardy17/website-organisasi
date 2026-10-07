<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Sistem Penilaian Kematangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0d3b66 0%, #145a8a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .login-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
            max-width: 900px;
            width: 100%;
        }
        .login-left {
            padding: 60px 50px;
        }
        .login-right {
            background: #0d3b66;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .login-right img {
            max-width: 200px;
        }
        .btn-login {
            background: #0d3b66;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            width: 100%;
            font-weight: 600;
        }
        .btn-login:hover {
            background: #145a8a;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-card row g-0">
            <div class="col-md-6 login-left">
                <h3 class="mb-4" style="color: #0d3b66; font-weight: 700;">Masuk Akun</h3>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('/login/attempt') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text"
                               name="username"
                               id="username"
                               class="form-control"
                               placeholder="Masukkan Username"
                               value="<?= session()->getFlashdata('username') ?? '' ?>"    <!-- Preserve -->
                               required
                               autofocus>
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>

                    <button type="submit" class="btn btn-login">Masuk</button>
                </form>
            </div>

            <div class="col-md-6 login-right">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2e/Lambang_Kota_Banjarbaru.png/200px-Lambang_Kota_Banjarbaru.png" alt="Logo Banjarbaru">
            </div>
        </div>
    </div>
</body>
</html>