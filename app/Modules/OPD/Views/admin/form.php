<?= $this->extend('App\Modules\Shared\Views\Layouts\Layout_admin') ?>

<?= $this->section('content') ?>

<h1>Tambah Akun OPD</h1>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card">
    <form action="<?= base_url('/admin/akun-opd/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="opd_id">Nama OPD</label>
            <select name="opd_id" id="opd_id" class="form-control" required>
                <option value="">-- Pilih OPD --</option>
                <?php foreach ($opd as $o): ?>
                    <option value="<?= $o['id'] ?>"><?= esc($o['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="nip_kepala">NIP</label>
            <input type="text" name="nip_kepala" id="nip_kepala"
                   class="form-control" placeholder="Nomor Induk Pegawai">
        </div>

        <div class="form-group">
            <label for="nama_kepala">Kepala OPD</label>
            <input type="text" name="nama_kepala" id="nama_kepala"
                   class="form-control" placeholder="Nama lengkap Kepala OPD">
        </div>

        <div class="form-group">
            <label for="pangkat_kepala">Pangkat/Golongan</label>
            <input type="text" name="pangkat_kepala" id="pangkat_kepala"
                   class="form-control" placeholder="Cth: Pembina / IV a">
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <div class="input-with-icon">
                <input type="text" name="password" id="password"
                       class="form-control"
                       placeholder="Ketik kata sandi baru"
                       required minlength="8">
                <button type="button" class="icon-btn" id="btn-dadu"
                        title="Generate password random"><i class="bi bi-dice-5"></i></button>
            </div>
            <small style="color:#6b7280; font-size:12px; display:block; margin-top:6px;">
                Minimal 8 karakter. Klik tombol dadu untuk generate otomatis.
            </small>
        </div>

        <div class="form-group">
            <label for="konfirmasi">Konfirmasi Kata Sandi</label>
            <input type="text" name="konfirmasi" id="konfirmasi"
                   class="form-control"
                   placeholder="Ulangi kata sandi"
                   required minlength="8">
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