<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class BarantinApiHelper
{
    private static $baseUrl = 'https://api.karantinaindonesia.go.id';
    private static $dataMasterUpt;
    private static $dataMasterNegara;
    private static $dataMasterProvinsi;
    private static $dataMasterKota;
    private static $dataMasterKotaByPronvisi = [];
    public static function getBaseUrl(): string
    {
        return self::$baseUrl;
    }
    /**
     * Melakukan panggilan API ke endpoint yang ditentukan.
     * @param string $endpoint Endpoint yang akan dipanggil.
     * @return JsonResponse Respon dari API.
     */
    private static function makeApiCall(string $endpoint): JsonResponse
    {
        $response = Http::withUserAgent( 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)')->withoutVerifying()->get(self::$baseUrl . $endpoint);

        if ($response->successful()) {
            return response()->json($response->json()['data']);
        } else {
            return response()->json(['error' => 'Failed to fetch data', 'status' => $response->status()]);
        }
    }

    /**
     * Mengambil data master UPT dari API dan menyimpannya dalam cache jika belum ada.
     * @return JsonResponse Respon JSON yang mengandung data master UPT.
     */
    public static function getDataMasterUpt(): JsonResponse
    {
        $cacheKey = 'dataMasterUpt';
        $cacheDuration = 60 * 24; // 1 hari dalam menit
        if (cache()->get($cacheKey) == null || now()->diffInMinutes(cache()->get($cacheKey . '_timestamp', now()->subDay())) >= $cacheDuration) {
            self::$dataMasterUpt = self::makeApiCall('/barantin-sys/upt/induk');
            cache()->put($cacheKey, self::$dataMasterUpt, $cacheDuration);
            cache()->put($cacheKey . '_timestamp', now(), $cacheDuration);
        } else {
            self::$dataMasterUpt = cache()->get($cacheKey);
        }

        return self::$dataMasterUpt;
    }
    /**
     * Mengambil data master negara dari API dan menyimpannya dalam cache jika belum ada.
     * @return JsonResponse Respon JSON yang mengandung data master negara.
     */
    public static function getDataMasterNegara(): JsonResponse
    {
        $cacheKey = 'dataMasterNegara';
        $cacheDuration = 60 * 24; // 1 hari dalam menit

        if (cache()->get($cacheKey) == null || now()->diffInMinutes(cache()->get($cacheKey . '_timestamp', now()->subDay())) >= $cacheDuration) {
            self::$dataMasterNegara = self::makeApiCall('/barantin-sys/negara');
            cache()->put($cacheKey, self::$dataMasterNegara, $cacheDuration);
            cache()->put($cacheKey . '_timestamp', now(), $cacheDuration);
        } else {
            self::$dataMasterNegara = cache()->get($cacheKey);
        }

        return self::$dataMasterNegara;
    }
    /**
     * Mengambil data master provinsi dari API dan menyimpannya dalam cache jika belum ada.
     * @return JsonResponse Respon JSON yang mengandung data master provinsi.
     */
    public static function getDataMasterProvinsi(): JsonResponse
    {
        $cacheKey = 'dataMasterProvinsi';
        $cacheDuration = 60 * 24; // 1 hari dalam menit


        if (cache()->get($cacheKey) == null || now()->diffInMinutes(cache()->get($cacheKey . '_timestamp', now()->subDay())) >= $cacheDuration) {
            self::$dataMasterProvinsi = self::makeApiCall('/barantin-sys/provinsi');
            cache()->put($cacheKey, self::$dataMasterProvinsi, $cacheDuration);
            cache()->put($cacheKey . '_timestamp', now(), $cacheDuration);
        } else {
            self::$dataMasterProvinsi = cache()->get($cacheKey);
        }

        return self::$dataMasterProvinsi;
    }
    /**
     * Mengambil data master kota dari API dan menyimpannya dalam cache jika belum ada.
     * @return JsonResponse Respon JSON yang mengandung data master kota.
     */
    public static function getDataMasterKota(): JsonResponse
    {
        $cacheKey = 'dataMasterKota';
        $cacheDuration = 60 * 24; // 1 hari dalam menit
        if (cache()->has($cacheKey) && now()->diffInMinutes(cache()->get($cacheKey . '_timestamp', now()->subDay())) < $cacheDuration) {
            self::$dataMasterKota = cache()->get($cacheKey);
        } else {
            self::$dataMasterKota = self::makeApiCall('/barantin-sys/kota');
            cache()->put($cacheKey, self::$dataMasterKota, $cacheDuration);
            cache()->put($cacheKey . '_timestamp', now(), $cacheDuration);
        }
        return self::$dataMasterKota;
    }
    /**
     * Memperoleh data kota berdasarkan ID provinsi dari API dan melakukan caching data tersebut.
     * @param int $provisi_id ID dari provinsi yang ingin diambil datanya.
     * @return JsonResponse Respon JSON yang berisi data kota berdasarkan provinsi.
     */
    public static function getDataMasterKotaByProvinsi(?int $provisi_id): JsonResponse
    {
        $cacheKey = 'dataMasterKotaByProvinsi_' . $provisi_id;
        $cacheDuration = 60 * 24; // 1 hari dalam menit

        if (cache()->has($cacheKey) && now()->diffInMinutes(cache()->get($cacheKey . '_timestamp', now()->subDay())) < $cacheDuration) {
            self::$dataMasterKotaByPronvisi[$provisi_id] = cache()->get($cacheKey);
        } else {
            self::$dataMasterKotaByPronvisi[$provisi_id] = self::makeApiCall('/barantin-sys/kota/prov/' . $provisi_id);
            cache()->put($cacheKey, self::$dataMasterKotaByPronvisi[$provisi_id], $cacheDuration);
            cache()->put($cacheKey . '_timestamp', now(), $cacheDuration);
        }
        return self::$dataMasterKotaByPronvisi[$provisi_id];
    }
    /**
     * Mengambil data master UPT berdasarkan ID.
     * @param mixed $id ID dari UPT yang ingin diambil.
     * @return mixed Mengembalikan data UPT jika ditemukan, atau null jika tidak ditemukan.
     */
    public static function getMasterUptByID($id)
    {
        $uptInstance = self::getDataMasterUpt();
        return collect($uptInstance->original)->where('id', $id)->first();
    }
    /**
     * Mengambil data negara berdasarkan ID.
     * Fungsi ini akan memanggil fungsi GetDataMasterNegara untuk mendapatkan semua data negara,
     * kemudian mencari dan mengembalikan data negara yang sesuai dengan ID yang diberikan.
     *
     * @param mixed $id ID dari negara yang ingin diambil.
     * @return mixed Mengembalikan data negara jika ditemukan, atau null jika tidak ditemukan.
     */
    public static function getMasterNegaraByID($id)
    {
        $negaraInstance = self::getDataMasterNegara();
        return collect($negaraInstance->original)->where('id', $id)->first();
    }
    /**
     * Mengambil data master provinsi berdasarkan ID.
     *
     * Fungsi ini akan memanggil API untuk mengambil data master provinsi.
     * Setelah itu, fungsi akan mencari provinsi dengan ID yang diberikan dan mengembalikan hasilnya.
     *
     * @param int $id ID dari provinsi yang ingin diambil.
     * @return mixed Mengembalikan data provinsi jika ditemukan, atau null jika tidak ditemukan.
     */
    public static function getMasterProvinsiByID($id)
    {
        $provinsiInstance = self::getDataMasterProvinsi();
        return collect($provinsiInstance->original)->where('id', $id)->first();
    }

    /**
     * Mengambil data master kota berdasarkan ID kota dan ID provinsi.
     *
     * Fungsi ini akan memanggil API untuk mengambil data master kota berdasarkan ID provinsi.
     * Setelah itu, fungsi akan mencari kota dengan ID yang diberikan dan mengembalikan hasilnya.
     *
     * @param int $id ID dari kota yang ingin diambil.
     * @param int $provinsi_id ID dari provinsi yang berkaitan dengan kota.
     * @return mixed Mengembalikan data kota jika ditemukan, atau null jika tidak ditemukan.
     */
    public static function getMasterKotaByIDProvinsiID(?int $id, ?int $provinsi_id)
    {
        $kotaInstance = self::getDataMasterKotaByProvinsi($provinsi_id);
        return collect($kotaInstance->original)->where('id', $id)->first();
    }
    /**
     * Mengambil data master kota berdasarkan ID.
     * Fungsi ini akan memanggil API untuk mengambil data master kota.
     * Setelah itu, fungsi akan mencari kota dengan ID yang diberikan dan mengembalikan hasilnya.
     *
     * @param int $id ID dari kota yang ingin diambil.
     * @return mixed Mengembalikan data kota jika ditemukan, atau null jika tidak ditemukan.
     */
    public static function getMasterKotaByID($id)
    {
        $kotaInstance = self::getDataMasterKota();
        return collect($kotaInstance->original)->where('id', $id)->first();
    }

    /**
     * Melakukan login ke API Barantin menggunakan username dan password.
     *
     * @param string $username Username pengguna.
     * @param string $password Password pengguna.
     */
    public static function loginApiBarantin(string $username, string $password)
    {
        $response = Http::withUserAgent( 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)')->withoutVerifying()->post(self::getBaseUrl() . '/ums/login', ['username' => $username, 'password' => $password]);
        return collect($response->json());

    }
    /**
     * Memperbarui token akses menggunakan refresh token yang diberikan.
     *
     * @param string $refreshToken Refresh token yang digunakan untuk mendapatkan token akses baru.
     */
    public static function refreshTokenApiBarantin(string $refreshToken)
    {
        $response = Http::withUserAgent( 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)')->withoutVerifying()->withToken($refreshToken)->get(self::getBaseUrl() . '/ums/refresh');
        return $response->json();
    }

}

