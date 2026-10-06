<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<h1>Dashboard Admin</h1>

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
        <table>
            <thead>
                <tr>
                    <th>Nama OPD</th>
                    <th style="width: 180px;">Tanggal</th>
                    <th style="width: 80px;">Skor</th>
                    <th style="width: 120px;">Status</th>
                    <th style="width: 140px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($antrean)): ?>
                    <tr>
                        <td colspan="5" class="empty-row">
                            Belum ada penilaian yang menunggu verifikasi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($antrean as $a): ?>
                        <tr>
                            <td><?= esc($a['nama_opd']) ?></td>
                            <td><?= $a['diajukan_pada'] ? date('d M Y H:i', strtotime($a['diajukan_pada'])) : '-' ?></td>
                            <td><?= number_format($a['total_skor'], 0) ?></td>
                            <td>
                                <span class="badge <?= $a['status'] === 'DIKIRIM' ? 'badge-submitted' : 'badge-verif-ulang' ?>">
                                    <?= esc($a['status']) ?>
                                </span>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= base_url('/admin/verifikasi/detail/' . $a['id']) ?>" class="btn">Verifikasi</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>