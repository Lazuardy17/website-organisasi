<?php
// Tentukan layout sesuai peran (di view saja)
$peranId = (int) session()->get('peran_id');

if ($peranId === 1) {
    $layout = 'App\Modules\Shared\Views\Layouts\Layout_admin';
    $dashboardUrl = base_url('/admin/dashboard');
} else {
    $layout = 'App\Modules\Shared\Views\Layouts\Layout_opd';
    $dashboardUrl = base_url('/opd/dashboard');
}
?>

<?= $this->extend($layout) ?>

<?= $this->section('content') ?>

<h1>Ganti Password Akun</h1>
<p class="subtitle">Isi form berikut untuk mengganti password akun Anda.</p>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<div class="card card-wide">
    <form action="<?= base_url('/ubah-password/simpan') ?>" method="post">
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="password_lama">Password Lama</label>
            <div class="input-with-icon">
                <input type="password" name="password_lama" id="password_lama"
                       class="form-control" placeholder="Masukkan password lama" required>
                <button type="button" class="toggle-password"
                        onclick="togglePassword('password_lama', this)" title="Lihat password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="#0d3b66"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="password_baru">Password Baru</label>
            <div class="input-with-icon">
                <input type="password" name="password_baru" id="password_baru"
                       class="form-control" placeholder="Minimal 8 karakter" required minlength="8">
                <button type="button" class="toggle-password"
                        onclick="togglePassword('password_baru', this)" title="Lihat password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="#0d3b66"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="form-group">
            <label for="konfirmasi">Konfirmasi Password</label>
            <div class="input-with-icon">
                <input type="password" name="konfirmasi" id="konfirmasi"
                       class="form-control" placeholder="Ulangi password baru" required minlength="8">
                <button type="button" class="toggle-password"
                        onclick="togglePassword('konfirmasi', this)" title="Lihat password">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                         viewBox="0 0 24 24" fill="none" stroke="#0d3b66"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
        </div>

        <div class="btn-group">
            <a href="<?= $dashboardUrl ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function togglePassword(inputId, button) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            button.classList.add('aktif');
            button.title = 'Sembunyikan password';
        } else {
            input.type = 'password';
            button.classList.remove('aktif');
            button.title = 'Lihat password';
        }
    }
</script>
<?= $this->endSection() ?>