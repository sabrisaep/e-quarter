<?php

if (!function_exists('format_tarikh_malaysia')) {
    /**
     * Menukar format datetime kepada format tarikh Malaysia
     * Contoh: 2026-06-14 -> 14 Jun 2026
     *
     * @param string $datetime
     * @return string
     */
    function format_tarikh_malaysia(string $datetime): string
    {
        if ($datetime == '0000-00-00' || $datetime == '0000-00-00 00:00:00') {
            return '-';
        }

        $bulan = ['', 'Januari', 'Februari', 'Mac', 'April', 'Mei', 'Jun', 'Julai', 'Ogos', 'September', 'Oktober', 'November', 'Disember'];

        $date = strtotime($datetime);
        $d = date('j', $date);
        $m = (int)date('n', $date);
        $y = date('Y', $date);

        return $d . ' ' . $bulan[$m] . ' ' . $y;
    }
}
