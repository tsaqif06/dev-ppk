<?php

namespace App\Http\Controllers\Api\User;

use App\Models\PjBarantin;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\BarantinCabang;
use App\Helpers\BarantinApiHelper;
use App\Helpers\StatusImportHelper;
use App\Http\Controllers\Controller;

class CabangController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (auth('sanctum')->user()->role === 'induk') {
                return $next($request);
            }
            abort(404);
        });
    }
    /**
     * @OA\Get(
     *     path="/user/cabang",
     *     operationId="getCabangPerusahaanInduk",
     *     tags={"User"},
     *     summary="Get Cabang Perusahaan Induk",
     *     description="Get Cabang Perusahaan Induk",
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
    public function getCabangPerusahaanInduk()
    {
        $data = PjBarantin::where('nomor_identitas', auth('sanctum')->user()->barantin->nomor_identitas)->whereNot('nitku', '000000');
        if ($data->exists()) {
            return ApiResponse::successResponse('Cabang Perusahaaan induk berhasil ditemukan', self::renderResponseDatas($data->get()), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }
    /**
     * @OA\Get(
     *     path="/user/cabang/{barantin_id}",
     *     operationId="getDetailCabangPerusahaanInduk",
     *     tags={"User"},
     *     summary="Get Detail Cabang Perusahaan Induk",
     *     description="Get Detail Cabang Perusahaan Induk",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="barantin_id",
     *         in="path",
     *         description="ID of the Barantin Cabang",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
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
    public function getDetailCabangPerusahaanInduk(string $barantin_cabang_id)
    {
        // return $barantin_cabang_id;
        $data = PjBarantin::find($barantin_cabang_id);
        if ($data) {
            return ApiResponse::successResponse('Cabang Perusahaaan induk berhasil ditemukan', self::renderResponseData($data), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }
    private static function renderResponseDatas($data)
    {
        $dataArray = [];
        foreach ($data as $item) {
            $dataArray[] = self::renderResponseData($item);
        }
        return $dataArray;
    }

    private static function renderResponseData($data)
    {
        $provinsi = BarantinApiHelper::getMasterProvinsiByID($data->provinsi_id);
        $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($data->kota, $data->provinsi_id);

        return [
            'barantin_id' => $data->id,
            'kode_perusahaan' => $data->kode_perusahaan,
            'pemohon' => $data->preregister->pemohon,
            'identifkasi_perusahaan' => $data->preregister->jenis_perusahaan,
            'jenis_perusahaan' => $data->jenis_perusahaan,
            'nama_perusahaan' => $data->nama_perusahaan ?? null,
            'nama_alias_perusahaan' => $data->nama_alias_perusahaan,
            'jenis_identitas' => $data->jenis_identitas,
            'nomor_identitas' => $data->nomor_identitas,
            'NITKU' => $data->nitku,
            'alamat' => $data->alamat,
            'provinsi' => $provinsi ? $provinsi['nama'] : null,
            'kota' => $kota ? $kota['nama'] : null,
            'telepon' => $data->telepon,
            'email' => $data->email,
            'fax' => $data->fax,
            'nama_cp' => $data->nama_cp,
            'alamat_cp' => $data->alamat_cp,
            'telepon_cp' => $data->telepon_cp,
            'nama_tdd' => $data->nama_tdd,
            'jenis_identitas_tdd' => $data->jenis_identitas_tdd,
            'nomor_identitas_tdd' => $data->nomor_identitas_tdd,
            'jabatan_tdd' => $data->jabatan_tdd,
            'alamat_tdd' => $data->alamat_tdd,
            'status_import' => StatusImportHelper::statusRender($data->status_import),
            'lingkup_aktifitas' => StatusImportHelper::aktifitasRender($data->lingkup_aktifitas),
        ];
    }
}
