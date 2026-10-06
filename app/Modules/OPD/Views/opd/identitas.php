<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_opd') ?>

<?= $this->section('content') ?>

<div class="alert alert-info">
    <i class="bi bi-bell-fill"></i> Silahkan mengisi Form Evaluasi Kematangan Kelembagaan terlebih dahulu!
</div>

<h1>Evaluasi Kematangan Kelembagaan</h1>
<p class="subtitle">Sesuai Peraturan Menteri Dalam Negeri Nomor: 99 Tahun 2018</p>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card">
    <form action="<?= base_url('/opd/identitas/simpan') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label>PD</label>
            <input type="text" class="form-control" 
                   value="<?= esc($opd['nama']) ?>" readonly>
        </div>

        <div class="form-group">
            <label for="nama_kepala">Kepala PD</label>
            <input type="text" name="nama_kepala" id="nama_kepala" 
                   class="form-control" 
                   placeholder="Nama Kepala Perangkat Daerah" 
                   value="<?= esc($opd['nama_kepala'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="pangkat_kepala">Pangkat/Golongan</label>
            <input type="text" name="pangkat_kepala" id="pangkat_kepala" 
                   class="form-control" 
                   placeholder="Cth: Pembina / IV a" 
                   value="<?= esc($opd['pangkat_kepala'] ?? '') ?>" required>
        </div>

        <div class="form-group">
            <label for="nip_kepala">NIP</label>
            <input type="text" name="nip_kepala" id="nip_kepala" 
                   class="form-control" 
                   placeholder="Nomor Induk Pegawai" 
                   value="<?= esc($opd['nip_kepala'] ?? '') ?>" required>
        </div>

        <div class="btn-group">
            <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>