<?php
/**
 * Template pager CodeIgniter 4 (dipakai lewat Config\Pager: 'admin_full').
 * Memakai kelas pagination Bootstrap 5 (sudah dimuat di Layout_admin).
 *
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>
<nav aria-label="Navigasi halaman">
    <ul class="pagination pagination-sm mb-0">
        <?php if ($pager->hasPreviousPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>" aria-label="Halaman pertama">&laquo;</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPreviousPage() ?>" aria-label="Sebelumnya">&lsaquo;</a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link) : ?>
            <li class="page-item<?= $link['active'] ? ' active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNextPage()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNextPage() ?>" aria-label="Berikutnya">&rsaquo;</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>" aria-label="Halaman terakhir">&raquo;</a>
            </li>
        <?php endif ?>
    </ul>
</nav>