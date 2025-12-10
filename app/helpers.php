<?php

if (!function_exists('tahunAjaran')) {
    /**
     * Jika $nilai (Collection) diberikan, ambil tahun_ajaran dari relasi tahunAjaran pada entri pertama.
     * Jika tidak, kembalikan tahun ajaran berdasarkan tanggal sekarang (logika: mulai 1 Juli).
     */
    function tahunAjaran($nilai = null)
    {
        // Jika collection/array diberikan dan ada relasi
        if ($nilai && is_object($nilai) && method_exists($nilai, 'count') && $nilai->count()) {
            $first = $nilai->first();
            if (isset($first->tahunAjaran) && isset($first->tahunAjaran->tahun_ajaran)) {
                return $first->tahunAjaran->tahun_ajaran;
            }
        }

        // fallback: hitung berdasarkan tanggal saat ini
        $tahun = (int) date('Y');
        $bulan = (int) date('n'); // 1-12
        if ($bulan < 7) {
            return ($tahun - 1) . '/' . $tahun;
        }
        return $tahun . '/' . ($tahun + 1);
    }
}
