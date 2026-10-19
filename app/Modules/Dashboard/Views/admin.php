<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Dashboard Admin</h1>
</div>

<!-- Stat Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total OPD Terdaftar</div>
        <div class="value"><?= $total_opd ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Belum Submit (draft)</div>
        <div class="value"><?= $belum_submit ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Menunggu Verifikasi</div>
        <div class="value"><?= $menunggu_verif ?? 0 ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Selesai Diverifikasi</div>
        <div class="value"><?= $terverifikasi ?? 0 ?></div>
    </div>
</div>

<!-- Tabel Antrean -->
<div class="card card-wide">
    <h2>Antrean verifikasi utama (SUBMITTED)</h2>
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
                <?php if (empty($antrean)): ?>
                    <tr>
                        <td colspan="7" class="empty-row">
                            Belum ada penilaian yang menunggu verifikasi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($antrean as $i => $a): ?>
                        <tr>
                            <td style="text-align: center;"><?= $i + 1 ?></td>
                            <td class="col-nama"><?= esc($a['nama_opd'] ?? '-') ?></td>
                            <td style="text-align: center;">
                                <?= $a['diajukan_pada'] ? tanggal_indonesia($a['diajukan_pada'], true) : '-' ?>
                            </td>
                            <td style="text-align: center;"><?= number_format($a['total_skor'], 0) ?></td>
                            <td style="text-align: center;"><?= esc($a['kesimpulan'] ?: '-') ?></td>
                            <td style="text-align: center;">
                                <span class="badge <?= $a['status'] === 'DIKIRIM' ? 'badge-submitted' : 'badge-verif-ulang' ?>">
                                    <?= esc(str_replace('_', ' ', $a['status'])) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('/admin/verifikasi/detail/' . $a['id']) . '?kembali=' . urlencode('/admin/dashboard') ?>" class="btn btn-primary">Lihat Detail</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>