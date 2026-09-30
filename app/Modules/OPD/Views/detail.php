<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <style>
        .card { border: 1px solid #ddd; padding: 20px; border-radius: 8px; margin: 20px 0; max-width: 500px; }
        .password-box { background: #fef3c7; padding: 16px; border-radius: 8px; margin: 16px 0; border: 1px dashed #f59e0b; }
        .password-box strong { font-size: 20px; color: #92400e; letter-spacing: 2px; }
        .btn { padding: 8px 16px; text-decoration: none; color: #fff; border-radius: 4px; border: none; cursor: pointer; }
        .btn-primary { background: #0d3b66; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>

    <?php if (session()->getFlashdata('password_sementara')): ?>
        <div class="password-box">
            <p><strong>⚠️ Password Sementara (hanya ditampilkan sekali):</strong></p>
            <p>Username: <strong><?= session()->getFlashdata('username_baru') ?></strong></p>
            <p>Password: <strong><?= session()->getFlashdata('password_sementara') ?></strong></p>
            <p><em>Silakan salin dan kirimkan ke OPD. Password ini tidak akan bisa dilihat lagi.</em></p>
        </div>
    <?php endif; ?>

    <div class="card">
        <h2><?= esc($akun['nama_opd']) ?></h2>
        <p><strong>Kode OPD:</strong> <?= esc($akun['kode_opd']) ?></p>
        <p><strong>Username:</strong> <?= esc($akun['nama_pengguna']) ?></p>
        <p><strong>Status:</strong> <?= esc($akun['status']) ?></p>
        <p><strong>Login Terakhir:</strong> <?= $akun['login_terakhir_pada'] ?? 'Belum pernah login' ?></p>
    </div>

    <p>
        <a href="<?= base_url('/admin/akun-opd') ?>" class="btn btn-primary">← Kembali ke Daftar</a>
    </p>
</body>
</html>