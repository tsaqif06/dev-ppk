<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Ppjk;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;

class PpjkController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/ppjk",
     *     operationId="getPpjk",
     *     tags={"User"},
     *     summary="Get PPJK",
     *     description="Get PPJK Pengguna Jasa",
     *     security={{"bearer_token":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data Not Found"
     *     )
     * )
     */
    public function getPpjk()
    {
        $data = Ppjk::where('pj_barantin_id', auth('sanctum')->user()->barantin->id);
        if ($data->exists()) {
            return ApiResponse::successResponse('Semua PPJK pengguna jasa', self::renderResponseDatas($data->get()), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }
    /**
     * @OA\Get(
     *     path="/user/ppjk/{ppjk_id}",
     *     operationId="getDetailPpjk",
     *     tags={"User"},
     *     summary="Get Detail PPJK Pengguna Jasa",
     *     description="Get Detail PPJK",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="ppjk_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data Not Found"
     *     )
     * )
     */
    public function getDetailPpjk(string $ppjk_id)
    {
        $data = Ppjk::find($ppjk_id);
        if ($data) {
            return ApiResponse::successResponse('Detail PPJK pengguna jasa', self::renderResponseData($data), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }

    private static function renderResponseDatas($data)
    {
        $dataArray = [];
        foreach ($data as $key => $item) {
            $dataArray[$key] = self::renderResponseData($item);
        }
        return $dataArray;
    }
    private static function renderResponseData($data)
    {
        $provinsi = BarantinApiHelper::getMasterProvinsiByID($data->master_provinsi_id);
        $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($data->master_kota_kab_id, $data->master_provinsi_id);

        return [
            'ppjk_id' => $data->id,
            'barantin_id' => $data->pj_barantin_id ?? null,
            'nama_ppjk' => $data->nama_ppjk,
            'jenis_identitas_ppjk' => $data->jenis_identitas_ppjk,
            'nomor_identitas_ppjk' => $data->nomor_identitas_ppjk,
            'email_ppjk' => $data->email_ppjk,
            'tanggal_kerjasama_ppjk' => date('Y-m-d', strtotime($data->tanggal_kerjasama_ppjk)),
            'alamat_ppjk' => $data->alamat_ppjk,
            'provinsi' => $provinsi['nama'] ?? null,
            'kota_kab' => $kota['nama'] ?? null,

            'nama_cp_ppjk' => $data->nama_cp_ppjk,
            'alamat_cp_ppjk' => $data->alamat_cp_ppjk,
            'telepon_cp_ppjk' => $data->telepon_cp_ppjk,

            'nama_tdd_ppjk' => $data->nama_tdd_ppjk,
            'jenis_identitas_tdd_ppjk' => $data->jenis_identitas_tdd_ppjk,
            'nomor_identitas_tdd_ppjk' => $data->nomor_identitas_tdd_ppjk,
            'jabatan_tdd_ppjk' => $data->jabatan_tdd_ppjk,
            'alamat_tdd_ppjk' => $data->alamat_tdd_ppjk,
        ];
    }
}
