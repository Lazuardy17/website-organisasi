<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<div class="page-header">
    <h1>Rekapitulasi Data</h1>
</div>

<!-- Filter -->
<div class="filter-card">
    <form action="<?= base_url('/admin/rekapitulasi') ?>" method="get">
        <div class="filter-row">
            <div class="filter-group">
                <label>Periode</label>
                <select name="periode_id">
                    <?php foreach ($periodeList as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= $p['id'] == $periodeId ? 'selected' : '' ?>>
                            <?= esc($p['tahun']) ?> - <?= esc($p['nama']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Status Verifikasi</label>
                <select name="status">
                    <option value="semua" <?= $statusFilter === 'semua' ? 'selected' : '' ?>>Semua Status</option>
                    <option value="DRAFT" <?= $statusFilter === 'DRAFT' ? 'selected' : '' ?>>DRAFT</option>
                    <option value="DIKIRIM" <?= $statusFilter === 'DIKIRIM' ? 'selected' : '' ?>>DIKIRIM</option>
                    <option value="PERLU_REVISI" <?= $statusFilter === 'PERLU_REVISI' ? 'selected' : '' ?>>PERLU REVISI</option>
                    <option value="TERVERIFIKASI" <?= $statusFilter === 'TERVERIFIKASI' ? 'selected' : '' ?>>TERVERIFIKASI</option>
                    <option value="PERLU_VERIFIKASI_ULANG" <?= $statusFilter === 'PERLU_VERIFIKASI_ULANG' ? 'selected' : '' ?>>PERLU VERIFIKASI ULANG</option>
                </select>
            </div>

            <button type="submit" class="btn-filter">Terapkan</button>
        </div>
    </form>
</div>

<!-- Statistik Ringkasan -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="label">Total OPD Dinilai</div>
        <div class="value"><?= $totalDinilai ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Terverifikasi</div>
        <div class="value"><?= $jumlahTerverifikasi ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Menunggu Verifikasi</div>
        <div class="value"><?= $jumlahMenunggu ?></div>
    </div>
    <div class="stat-card">
        <div class="label">Rata-rata Skor</div>
        <div class="value"><?= number_format($rataRataSkor, 0) ?></div>
    </div>
</div>

<!-- Tabel Rekapitulasi -->
<?php $nomorAwal = ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
<div class="card card-wide">
    <h2>Rekapitulasi OPD</h2>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th style="width: 50px;">No</th>
                    <th>Nama OPD</th>
                    <th style="width: 150px;">Tanggal Submit</th>
                    <th style="width: 100px;">Skor</th>
                    <th style="width: 200px;">Status</th>
                    <th style="width: 130px; text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar)): ?>
                    <tr>
                        <td colspan="6" class="empty-row">
                            Belum ada data penilaian untuk filter ini.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($daftar as $i => $d): ?>
                        <?php
                            $badgeClass = 'badge-draft';
                            if ($d['status'] === 'DIKIRIM') $badgeClass = 'badge-submitted';
                            elseif ($d['status'] === 'PERLU_REVISI') $badgeClass = 'badge-perlu-revisi';
                            elseif ($d['status'] === 'TERVERIFIKASI') $badgeClass = 'badge-terverifikasi';
                            elseif ($d['status'] === 'PERLU_VERIFIKASI_ULANG') $badgeClass = 'badge-verif-ulang';
                        ?>
                        <tr>
                            <td><?= $nomorAwal + $i + 1 ?></td>
                            <td class="col-nama"><?= esc($d['nama_opd']) ?></td>
                            <td><?= $d['diajukan_pada'] ? date('d M Y', strtotime($d['diajukan_pada'])) : '-' ?></td>
                            <td class="skor"><?= $d['total_skor'] > 0 ? number_format($d['total_skor'], 0) : '-' ?></td>
                            <td>
                                <span class="badge <?= $badgeClass ?>"><?= esc($d['status']) ?></span>
                            </td>
                            <td class="col-aksi">
                                <a href="<?= base_url('/admin/verifikasi/detail/' . $d['id']) ?>" class="btn">
                                    Lihat Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?= view('App\Modules\Shared\Views\Components\pagination', ['pager' => $pager]) ?>
</div>

<?= $this->endSection() ?>