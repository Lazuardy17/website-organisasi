<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<h1>Edit Akun OPD</h1>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card">
    <form action="<?= base_url('/admin/akun-opd/update/' . $akun['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="nama_opd">Nama OPD</label>
            <input type="text" name="nama_opd" id="nama_opd"
                   class="form-control"
                   value="<?= old('nama_opd', $akun['nama_opd'] ?? '') ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="nama_pengguna">Username</label>
            <input type="text" name="nama_pengguna" id="nama_pengguna"
                   class="form-control"
                   value="<?= old('nama_pengguna', $akun['nama_pengguna']) ?>"
                   required>
        </div>

        <div class="form-group">
            <label for="nip_kepala">NIP</label>
            <input type="text" name="nip_kepala" id="nip_kepala"
                   class="form-control"
                   value="<?= old('nip_kepala', $akun['nip_kepala'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="nama_kepala">Kepala OPD</label>
            <input type="text" name="nama_kepala" id="nama_kepala"
                   class="form-control"
                   value="<?= old('nama_kepala', $akun['nama_kepala'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="pangkat_kepala">Pangkat/Golongan</label>
            <input type="text" name="pangkat_kepala" id="pangkat_kepala"
                   class="form-control"
                   value="<?= old('pangkat_kepala', $akun['pangkat_kepala'] ?? '') ?>">
        </div>

        <hr style="margin: 24px 0; border: none; border-top: 1px solid #e5e7eb;">

        <div class="form-group">
            <label for="password">Kata Sandi Baru <small style="font-weight:400; color:#6b7280;">(kosongkan jika tidak diubah)</small></label>
            <div class="input-with-icon">
                <input type="text" name="password" id="password"
                       class="form-control"
                       placeholder="Kata sandi baru (opsional)">
                <button type="button" class="icon-btn" id="btn-dadu"
                        title="Generate password random">🎲</button>
            </div>
        </div>

        <div class="form-group">
            <label for="konfirmasi">Konfirmasi Kata Sandi Baru</label>
            <input type="text" name="konfirmasi" id="konfirmasi"
                   class="form-control"
                   placeholder="Ulangi kata sandi baru">
        </div>

        <div class="btn-group">
            <a href="<?= base_url('/admin/akun-opd') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.getElementById('btn-dadu').addEventListener('click', function () {
        const chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let pass = '';
        for (let i = 0; i < 8; i++) {
            pass += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.getElementById('password').value = pass;
        document.getElementById('konfirmasi').value = pass;
    });
</script>
<?= $this->endSection() ?>