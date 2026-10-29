<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Verifikasi Penilaian</h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<?php /* [PAGINATION 1/3] nomor awal halaman ini (halaman 2 mulai dari 11, dst.) */ ?>
<?php $nomorAwal = ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
<?php
// Alamat halaman ini (beserta filter & nomor halaman) untuk tombol "Kembali" di halaman detail
$qs      = service('request')->getUri()->getQuery();
$kembali = '/' . uri_string() . ($qs !== '' ? '?' . $qs : '');
?>

<div class="card card-wide">
    <div class="table-responsive">
        <table style="table-layout: fixed; width: 100%;">
            <colgroup>
                <col style="width: 5%;">    <!-- No -->
                <col style="width: 27%;">   <!-- Nama OPD -->
                <col style="width: 17%;">   <!-- Tanggal Submit -->
                <col style="width: 9%;">    <!-- Total Skor -->
                <col style="width: 13%;">   <!-- Predikat -->
                <col style="width: 16%;">   <!-- Status -->
                <col style="width: 13%;">   <!-- Aksi -->
            </colgroup>
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama OPD</th>
                    <th style="text-align: center;">Tanggal Submit</th>
                    <th style="text-align: center;">Skor</th>
                    <th style="text-align: center;">Predikat</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar)): ?>
                    <tr>
                        <td colspan="7" class="empty-row">
                            Belum ada penilaian yang menunggu verifikasi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftar as $i => $d): ?>
                        <tr>
                            <?php /* [PAGINATION 2/3] nomor urut berlanjut antar halaman */ ?>
                            <td style="text-align: center;"><?= $nomorAwal + $i + 1 ?></td>
                            <td class="col-nama"><?= esc($d['nama_opd'] ?? '-') ?></td>
                            <td style="text-align: center;"><?= tanggal_indonesia($d['diajukan_pada']) ?></td>
                            <td style="text-align: center;"><?= number_format($d['total_skor'], 0) ?></td>
                            <td style="text-align: center;"><?= esc($d['kesimpulan'] ?: '-') ?></td>
                            <td style="text-align: center;">
                                <span class="badge <?= $d['status'] === 'DIKIRIM' ? 'badge-submitted' : 'badge-verif-ulang' ?>">
                                    <?= esc(str_replace('_', ' ', $d['status'])) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('/admin/verifikasi/detail/' . $d['id']) . '?kembali=' . urlencode($kembali) ?>" class="btn btn-primary">Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php /* [PAGINATION 3/3] teks "Menampilkan x-y dari z" + tombol halaman */ ?>
    <?= view('App\Modules\Shared\Views\Components\pagination', ['pager' => $pager]) ?>
</div>

<?= $this->endSection() ?>