<?php
/*Wrapper untuk ekspor 1 OPD oleh Admin.*/
echo view('App\Modules\Laporan\Views\opd_pdf', [
    'opd'          => $opd,
    'periode'      => $periode,
    'penilaian'    => $penilaian,
    'detail'       => $detail,
    'variabelList' => $variabelList,
    'format'       => $format,
]);