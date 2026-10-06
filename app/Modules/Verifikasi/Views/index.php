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

<?php if (empty($daftar)): ?>
    <div class="alert alert-info">Belum ada penilaian yang menunggu verifikasi.</div>
<?php else: ?>
    <div class="card card-wide">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="width: 50px;">No</th>
                        <th>Nama OPD</th>
                        <th style="width: 100px;">Periode</th>
                        <th style="width: 160px;">Tanggal Submit</th>
                        <th style="width: 100px;">Total Skor</th>
                        <th style="width: 140px;">Status</th>
                        <th style="width: 130px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($daftar as $i => $d): ?>
                        <tr>
                            <td><?= $i + 1 ?></td>
                            <td class="col-nama"><?= esc($d['nama_opd']) ?></td>
                            <td><?= esc($d['tahun_periode']) ?></td>
                            <td><?= $d['diajukan_pada'] ? date('d M Y H:i', strtotime($d['diajukan_pada'])) : '-' ?></td>
                            <td><?= number_format($d['total_skor'], 0) ?></td>
                            <td>
                                <span class="badge <?= $d['status'] === 'DIKIRIM' ? 'badge-submitted' : 'badge-verif-ulang' ?>">
                                    <?= esc($d['status']) ?>
                                </span>
                            </td>
                            <td class="col-aksi">
                                <a href="<?= base_url('/admin/verifikasi/detail/' . $d['id']) ?>" class="btn btn-primary">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>