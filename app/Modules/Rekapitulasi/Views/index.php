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
<?php /* [PAGINATION 1/3] nomor awal halaman ini (halaman 2 mulai dari 11, dst.) */ ?>
<?php $nomorAwal = ($pager->getCurrentPage() - 1) * $pager->getPerPage(); ?>
<?php
// Alamat halaman ini (beserta filter & nomor halaman) untuk tombol "Kembali" di halaman detail
$qs      = service('request')->getUri()->getQuery();
$kembali = '/' . uri_string() . ($qs !== '' ? '?' . $qs : '');
?>

<div class="card card-wide">
    <h2>Rekapitulasi OPD</h2>

    <!-- Urutan tabel (periode & status dibawa lewat input tersembunyi; halaman kembali ke 1) -->
    <form action="<?= base_url('/admin/rekapitulasi') ?>" method="get" class="filter-row" style="align-items: center; margin-bottom: 16px;">
        <input type="hidden" name="periode_id" value="<?= esc($periodeId) ?>">
        <input type="hidden" name="status" value="<?= esc($statusFilter) ?>">

        <label for="urutkan" style="color: var(--navy); font-size: 14px; font-weight: 600;">Urutkan berdasarkan:</label>

        <div class="filter-group">
            <select name="urutkan" id="urutkan" onchange="this.form.submit()">
                <option value="id_opd" <?= $urutkan === 'id_opd' ? 'selected' : '' ?>>ID OPD</option>
                <option value="skor" <?= $urutkan === 'skor' ? 'selected' : '' ?>>Skor</option>
                <option value="perubahan" <?= $urutkan === 'perubahan' ? 'selected' : '' ?>>Perubahan Terakhir</option>
            </select>
        </div>

        <div class="filter-group">
            <select name="arah" id="arah" aria-label="Arah urutan" onchange="this.form.submit()" style="min-width: 140px;">
                <option value="asc" <?= $arah === 'asc' ? 'selected' : '' ?>>Menaik</option>
                <option value="desc" <?= $arah === 'desc' ? 'selected' : '' ?>>Menurun</option>
            </select>
        </div>

        <noscript><button type="submit" class="btn-filter">Terapkan</button></noscript>
    </form>

    <div class="table-responsive">
        <table style="table-layout: fixed; width: 100%;">
            <colgroup>
                <col style="width: 5%;">    <!-- No -->
                <col style="width: 15%;">   <!-- Nama OPD -->
                <col style="width: 10%;">   <!-- Tanggal Submit -->
                <col style="width: 15%;">   <!-- Perubahan Terakhir -->
                <col style="width: 5%;">    <!-- Skor -->
                <col style="width: 6%;">   <!-- Predikat -->
                <col style="width: 10%;">   <!-- Status -->
                <col style="width: 12%;">   <!-- Aksi -->
            </colgroup>
            <thead>
                <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;">Nama OPD</th>
                    <th style="text-align: center;">Tanggal Submit</th>
                    <th style="text-align: center;">Perubahan Terakhir</th>
                    <th style="text-align: center;">Skor</th>
                    <th style="text-align: center;">Predikat</th>
                    <th style="text-align: center;">Status</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($daftar)): ?>
                    <tr>
                        <td colspan="9" class="empty-row">
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
                            <?php /* [PAGINATION 2/3] nomor urut berlanjut antar halaman */ ?>
                            <td style="text-align: center;"><?= $nomorAwal + $i + 1 ?></td>
                            <td class="col-nama"><?= esc($d['nama_opd'] ?? '-') ?></td>
                            <td style="text-align: center;"><?= tanggal_indonesia($d['diajukan_pada']) ?></td>
                            <td style="text-align: center;"><?= tanggal_indonesia($d['diperbarui_pada'] ?: $d['dibuat_pada'], true) ?></td>
                            <td class="skor" style="text-align: center;"><?= $d['total_skor'] > 0 ? number_format($d['total_skor'], 0) : '-' ?></td>
                            <td style="text-align: center;"><?= esc($d['kesimpulan'] ?: '-') ?></td>
                            <td style="text-align: center;">
                                <span class="badge <?= $badgeClass ?>"><?= esc(str_replace('_', ' ', $d['status'])) ?></span>
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