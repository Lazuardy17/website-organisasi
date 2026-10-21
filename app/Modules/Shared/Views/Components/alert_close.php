<?php
/**
 * Tombol "×" untuk menutup setiap notifikasi (elemen berkelas .alert).
 *
 * Cara pakai — satu baris di layout / halaman, tepat sebelum </body>:
 *
 *   <?= view('App\Modules\Shared\Views\Components\alert_close') ?>
 *
 * Notifikasi yang TIDAK boleh ditutup (mis. pengingat penting): beri atribut data-tetap
 *
 *   <div class="alert alert-info" data-tetap>...</div>
 *
 * Catatan: tombol ditambahkan saat halaman selesai dimuat, jadi notifikasi yang dibuat
 * belakangan lewat JavaScript tidak otomatis mendapat tombol ini.
 */
?>
<style>
    .alert { position: relative; }
    .alert.alert-dapat-ditutup { padding-right: 44px; }
    .alert .alert-close {
        position: absolute;
        top: 50%;
        right: 12px;
        transform: translateY(-50%);
        padding: 0 6px;
        border: 0;
        background: transparent;
        color: inherit;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        opacity: .6;
    }
    .alert .alert-close:hover,
    .alert .alert-close:focus-visible { opacity: 1; }
    .alert.alert-menutup { opacity: 0; transition: opacity .15s ease; }
</style>
<script>
    (function () {
        document.querySelectorAll('.alert:not([data-tetap])').forEach(function (el) {
            var tombol = document.createElement('button');
            tombol.type = 'button';
            tombol.className = 'alert-close';
            tombol.setAttribute('aria-label', 'Tutup notifikasi');
            tombol.title = 'Tutup';
            tombol.innerHTML = '&times;';

            tombol.addEventListener('click', function () {
                el.classList.add('alert-menutup');
                setTimeout(function () { el.remove(); }, 150);
            });

            el.classList.add('alert-dapat-ditutup');
            el.appendChild(tombol);
        });
    })();
</script>