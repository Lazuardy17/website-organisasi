<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1>Dashboard Admin</h1>
    <p>Selamat datang, <?= session()->get('username') ?>!</p>

    <hr>

    <h2>Statistik</h2>
    <ul>
        <li>Total OPD Terdaftar: <?= $total_opd ?></li>
        <li>Belum Submit: <?= $belum_submit ?></li>
        <li>Menunggu Verifikasi: <?= $menunggu_verif ?></li>
        <li>Terverifikasi: <?= $terverifikasi ?></li>
    </ul>

    <hr>

    <p>
        <a href="<?= base_url('/logout') ?>">Logout</a>
    </p>
</body>
</html>