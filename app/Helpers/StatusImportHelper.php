<?php

namespace App\Helpers;

class StatusImportHelper
{
    public static function statusRender($status)
    {
        $statuses = [
            25 => 'Importir Umum',
            26 => 'Importir Produsen',
            27 => 'Importir Terdaftar',
            28 => 'Agen Tunggal',
            29 => 'BULOG',
            30 => 'PERTAMINA',
            31 => 'DAHANA',
            32 => 'IPTN',
        ];
        return $statuses[$status] ?? null;

    }
    public static function aktifitasRender($aktifitas)
    {
        $data = [
            1 => 'Import',
            2 => 'Domestik Masuk',
            3 => 'Export',
            4 => 'Domestik Keluar',
        ];
        $array = explode(',', $aktifitas);
        $filteredData = array_filter($data, function ($key) use ($array) {
            return in_array($key, $array);
        }, ARRAY_FILTER_USE_KEY);

        return implode(', ', $filteredData);
    }
}
