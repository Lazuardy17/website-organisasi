<?php
/**
 * Komponen pagination: teks "Menampilkan x–y dari z data" + tombol halaman.
 * Dipanggil dari view:
 *   <?= view('App\Modules\Shared\Views\Components\pagination', ['pager' => $pager]) ?>
 *
 * @var \CodeIgniter\Pager\Pager $pager  (dari $model->pager)
 */
$total   = $pager->getTotal();
$perPage = $pager->getPerPage();
$halaman = $pager->getCurrentPage();
$dari    = ($halaman - 1) * $perPage + 1;
$sampai  = min($halaman * $perPage, $total);
?>
<?php if ($total > 0): ?>
    <style>
        .pager-bar { display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px; padding: 14px 4px 2px; }
        .pager-bar .pager-info { font-size: 13px; color: #6b7280; }
        .pager-bar .page-link { color: var(--navy, #013D58); }
        .pager-bar .page-item.active .page-link { background: var(--navy, #013D58); border-color: var(--navy, #013D58); color: #fff; }
        .pager-bar .page-link:focus { box-shadow: 0 0 0 .2rem rgba(1, 61, 88, .2); }
    </style>
    <div class="pager-bar">
        <div class="pager-info">Menampilkan <?= $dari ?>&ndash;<?= $sampai ?> dari <?= $total ?> data</div>
        <?php if ($pager->getPageCount() > 1): ?>
            <?= $pager->links('default', 'admin_full') ?>
        <?php endif; ?>
    </div>
<?php endif; ?>