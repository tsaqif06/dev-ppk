<?php

namespace App\Http\Controllers\Api;

use App\Models\Register;
use App\Models\PjBarantin;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\BarantinCabang;
use App\Models\MitraPerusahaan;
use App\Helpers\PaginationHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;

class BarantinMitraController extends Controller
{
    private $uptPusatId;
    public function __construct()
    {
        $this->uptPusatId = env('UPT_PUSAT_ID', 1000);
    }
    /**
     * @OA\Get(
     *     path="/mitra/{barantin_id}/barantin",
     *     tags={"Mitra Admin"},
     *     summary="Semua Data Mitra Perusahaan induk / Perusahaan Cabang / Perorangan Berdasarkan ID Barantin / ID Barantin Cabang",
     *     description="Semua Data Mitra Perusahaan Berdasarkan ID Barantin endpoint: '/barantin/{barantin_id}/mitra' barantin_id  adalah ID Barantin",
     *     operationId="GetAllDataMitraBybarantinID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="barantin_id",
     *         in="path",
     *         description="ID Barantin",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="barantin mitra data"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="PT. Mitra Sejahtera"),
     *                     @OA\Property(property="email", type="string", example="mitra.sejahtera@example.com"),
     *                     @OA\Property(property="no_hp", type="string", example="08123456789"),
     *                     @OA\Property(property="alamat", type="string", example="Jl. Sudirman No. 123"),
     *                     @OA\Property(property="created_at", type="string", example="2023-02-28 12:34:56"),
     *                     @OA\Property(property="updated_at", type="string", example="2023-02-28 12:34:56"),
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function GetAllDataMitraByBarantinID(string $barantin_id): JsonResponse
    {
        $data = MitraPerusahaan::where('pj_barantin_id', $barantin_id);
        if ($data->count() > 0) {
            return ApiResponse::successResponse('Barantin mitra data', self::renderDataResponses($data->get()), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }

    /**
     * @OA\Get(
     *     path="/mitra/{mitra_id}",
     *     tags={"Mitra Admin"},
     *     summary="Mendapatkan Data Mitra Berdasarkan ID",
     *     description="Endpoint untuk mendapatkan data mitra berdasarkan ID yang diberikan",
     *     operationId="getAllDataMitraByID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="mitra_id",
     *         in="path",
     *         description="ID Mitra",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data mitra ditemukan"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama_mitra", type="string", example="PT. Mitra Sejahtera"),
     *                 @OA\Property(property="email", type="string", example="mitra@example.com"),
     *                 @OA\Property(property="no_hp", type="string", example="081234567890"),
     *                 @OA\Property(property="alamat", type="string", example="Jl. Kemerdekaan No. 45"),
     *                 @OA\Property(property="created_at", type="string", example="2023-03-01 12:00:00"),
     *                 @OA\Property(property="updated_at", type="string", example="2023-03-01 12:00:00"),
     *             )
     *         )
     *     )
     * )
     */
    public function GetAllDataMitraByID(string $mitra_id): JsonResponse
    {
        $data = MitraPerusahaan::find($mitra_id);
        if ($data) {
            return ApiResponse::successResponse('barantin mitra data', self::renderDataResponse($data), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }

    private static function renderDataResponses($data, bool $pagination = false): array
    {
        $response = [];
        foreach ($data as $item) {
            $response[] = self::renderDataResponse($item);
        }
        if ($pagination) {
            $response = PaginationHelper::pagination($data, $response);
        }
        return $response;
    }

    private static function renderDataResponse($data): array
    {

        $negara = BarantinApiHelper::getMasterNegaraByID($data->master_negara_id);
        $provinsi = $data->master_provinsi_id ? BarantinApiHelper::getMasterProvinsiByID($data->master_provinsi_id) : null;
        $kota = $data->master_kota_kab_id ? BarantinApiHelper::getMasterKotaByIDProvinsiID($data->master_kota_kab_id, $data->master_provinsi_id) : null;

        $data = [
            "mitra_id" => $data->id,
            "nama_perusahaan_induk" => $data->barantin->nama_perusahaan ?? null,
            "nama_perusahaan_cabang" => $data->barantincabang->nama_perusahaan ?? null,
            "nama_mitra" => $data->nama_mitra,
            "jenis_identitas_mitra" => $data->jenis_identitas_mitra,
            "nomor_identitas_mitra" => $data->nomor_identitas_mitra,
            "alamat_mitra" => $data->alamat_mitra,
            "telepon_mitra" => $data->telepon_mitra,
            "negara" => $negara['nama'] ?? null,
            "provinsi" => $provinsi['nama'] ?? null,
            "kota" => $kota['nama'] ?? null,
        ];
        return $data;
    }

}
