<?php

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

if (! function_exists('tanggal_indonesia')) {
    /**
     * Format tanggal/waktu ke bahasa Indonesia.
     * Contoh: "5 Oktober 2026" atau (dengan jam) "5 Oktober 2026, 08:01".
     *
     * @param string|null $waktu     nilai tanggal, mis. dari kolom DATETIME. Kosong => "-"
     * @param bool        $denganJam tambahkan jam:menit di belakang tanggal
     */
    function tanggal_indonesia(?string $waktu, bool $denganJam = false): string
    {
        // Kosong atau "zero date" MySQL (0000-00-00 ...) dianggap belum ada
        if (empty($waktu) || str_starts_with($waktu, '0000')) {
            return '-';
        }

        $ts = strtotime($waktu);
        if ($ts === false) {
            return '-';
        }

        $bulan = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        $hasil = date('j', $ts) . ' ' . $bulan[(int) date('n', $ts)] . ' ' . date('Y', $ts);

        return $denganJam ? $hasil . ', ' . date('H:i', $ts) : $hasil;
    }
}