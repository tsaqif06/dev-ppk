<?php

namespace App\Http\Controllers\Api;

use App\Models\Ppjk;
use App\Models\Register;
use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;

class BarantinPpjkController extends Controller
{
    private $uptPusatId;
    public function __construct()
    {
        $this->uptPusatId = env('UPT_PUSAT_ID', 1000);
    }

    /**
     * @OA\Get(
     *     path="/ppjk/{barantin_id}",
     *     operationId="getPpjkByPerusahaanId",
     *     tags={"PPJK Admin"},
     *     summary="Get PPJK by  Perusahaan induk / Perusahaan Cabang / Perorangan Berdasarkan ID Barantin / ID Barantin Cabang",
     *     description="Get PPJK by Perusahaan ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="barantin_id",
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
    public function getPpjkByBarantinId(string $barantin_id)
    {
        $data = Ppjk::where('pj_barantin_id', $barantin_id);
        if ($data->exists()) {
            return ApiResponse::successResponse('Semua PPJK pengguna jasa', self::renderResponseDatas($data->get(), false), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }
    /**
     * @OA\Get(
     *     path="/ppjk/{ppjk_id}/detil",
     *     operationId="getDetailPpjkAdmin",
     *     tags={"PPJK Admin"},
     *     summary="Get Detail PPJK",
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

    /**
     * @OA\Get(
     *     path="/ppjk/cek-npwp",
     *     operationId="cekNpwpPpjk",
     *     tags={"PPJK Admin"},
     *     summary="Cek NPWP PPJK",
     *     description="Cek NPWP PPJK",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="kd_upt",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="npwp_ppjk",
     *         in="query",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="npwp_pj",
     *         in="query",
     *         required=false,
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
    public function cekNpwpPpjk()
    {
        $kdUpt = request()->input('kd_upt');
        $npwpPpjk = request()->input('npwp_ppjk');
        $npwpPj = request()->input('npwp_pj');

        if ($npwpPpjk != null) {
            $data = Register::with(['barantin', 'barantin.ppjk'])->where('master_upt_id', $kdUpt)->whereHas('barantin', function ($query) use ($npwpPj) {
                $query->where('jenis_identitas', 'NPWP')->where('nomor_identitas', $npwpPj);
            })->whereHas('barantin.ppjk', function ($query) use ($npwpPpjk) {
                $query->where('nomor_identitas_ppjk', $npwpPpjk);
            })->first();
            $data['ppjk'] = true;
        } elseif ($npwpPj != null) {
            $data = Register::with(['barantin'])
                ->where('master_upt_id', $kdUpt)
                ->whereHas('barantin', function ($query) use ($npwpPj) {
                    $query->where('jenis_identitas', 'NPWP')->where('nomor_identitas', $npwpPj);
                })
                ->first();
        }
        if ($kdUpt && $data) {
            return ApiResponse::successResponse('Pengecekan ditemukan', self::renderResponseCek($data), false);
        }
        return ApiResponse::errorResponse('data not found', 404);

    }

    private static function renderResponseCek($data)
    {
        if (isset($data['ppjk'])) {
            $dataRes = [
                'ppjk_id' => $data->barantin->ppjk[0]->id,
                // 'kode_perusahaan' => $data->barantin->ppjk->kode_perusahaan,
                'jenis_perusahaan' => $data->barantin->ppjk[0]->jenis_perusahaan,
                'provinsi' => $data->barantin->ppjk[0]->master_provinsi_id,
                'kota' => $data->barantin->ppjk[0]->master_kota_kab_id
            ];
            return $dataRes;
        }
        $dataRes = [
            'barantin_id' => $data->barantin->id,
            'kode_perusahaan' => $data->barantin->kode_perusahaan,
            'jenis_perusahaan' => $data->barantin->jenis_perusahaan,
            'provinsi' => $data->barantin->provinsi_id,
            'kota' => $data->barantin->kota
        ];
        return $dataRes;
    }

    private static function renderResponseDatas($data, bool $pagination)
    {
        $dataArray = [];
        foreach ($data as $key => $item) {
            $dataArray[$key] = self::renderResponseData($item);
        }

        if ($pagination) {
            return PaginationHelper::pagination($data, $dataArray);
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
            'barantin_cabang_id' => $data->barantin_cabang_id ?? null,
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
