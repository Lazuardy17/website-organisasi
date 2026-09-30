<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?></title>
</head>
<body>
    <h1>Dashboard User OPD</h1>
    <p>Selamat datang, <?= session()->get('username') ?>!</p>

    <hr>

    <h2>Progres Pengisian</h2>
    <ul>
        <li>Total Variabel: <?= $total_variabel ?></li>
        <li>Belum Diisi: <?= $belum_diisi ?></li>
        <li>Status: <?= $status ?></li>
        <li>Skor: <?= $skor ?? '-' ?></li>
    </ul>

    <hr>

    <p>
        <a href="<?= base_url('/logout') ?>">Logout</a>
    </p>
</body>
</html>