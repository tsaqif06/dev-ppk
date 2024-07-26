<?php

namespace App\Http\Controllers\Api\User;

use App\Rules\KotaRule;
use App\Rules\NegaraRule;
use App\Rules\ProvinsiRule;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Models\MitraPerusahaan;
use Illuminate\Validation\Rule;
use App\Helpers\PaginationHelper;
use App\Rules\NomerIdentitasRule;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;



class MitraController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/mitra",
     *     summary="Ambil Semua User Mitra di masing masing perngguna jasa",
     *     tags={"User"},
     *     security={{ "bearer_token": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(
     *                             property="id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                         @OA\Property(
     *                             property="nama_mitra",
     *                             type="string",
     *                             example="Nama Mitra"
     *                         ),
     *                         @OA\Property(
     *                             property="jenis_identitas_mitra",
     *                             type="string",
     *                             example="KTP"
     *                         ),
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllMitraUser()
    {
        $data = MitraPerusahaan::where('pj_barantin_id', auth('sanctum')->user()->barantin->id)->orderBy('created_at', 'desc');
        if ($data->count() > 0) {
            return ApiResponse::successResponse('Semua Mitra pengguna jasa', self::renderDataResponses($data->get()), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }
    /**
     * @OA\Get(
     *     path="/user/mitra/{mitra_id}",
     *     summary="Ambil data mitra pengguna jasa berdasarkan id",
     *     tags={"User"},
     *     security={{ "bearer_token": {} }},
     *     parameters={
     *         {
     *             "in": "path",
     *             "name": "mitra_id",
     *             "required": true,
     *             "schema": {
     *                 "type": "string"
     *             }
     *         }
     *     },
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="nama_mitra",
     *                         type="string",
     *                         example="Nama Mitra"
     *                     ),
     *                     @OA\Property(
     *                         property="jenis_identitas_mitra",
     *                         type="string",
     *                         example="KTP"
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */

    public function getMitraByID(string $mitra_id)
    {
        $data = MitraPerusahaan::find($mitra_id);
        if ($data) {
            return ApiResponse::successResponse('Detail mitra pengguna jasa', self::renderDataResponse($data), false);
        }
        return ApiResponse::errorResponse('data not found', 404);
    }
    /**
     * @OA\Post(
     *     path="/user/mitra/store",
     *     tags={"User"},
     *     summary="Membuat Mitra Baru Perusahaan Induk / Cabang dan Peorangan",
     *     description="Endpoint untuk membuat mitra baru",
     *     operationId="createMitra",
     *     security={{"bearer_token":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_mitra", type="string", example="Nama Mitra"),
     *             @OA\Property(property="jenis_identitas_mitra", type="string", example="KTP"),
     *             @OA\Property(property="nomor_identitas_mitra", type="integer", example=1234567812345678),
     *             @OA\Property(property="alamat_mitra", type="string", example="Alamat Mitra"),
     *             @OA\Property(property="telepon_mitra", type="string", example="1234-5678-9012"),
     *             @OA\Property(property="negara", type="integer", example=99),
     *             @OA\Property(property="provinsi", type="integer", example=11),
     *             @OA\Property(property="kabupaten_kota", type="integer", example=1101)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     type="object",
     *                     @OA\Property(
     *                         property="id",
     *                         type="integer",
     *                         example=1
     *                     ),
     *                     @OA\Property(
     *                         property="nama_mitra",
     *                         type="string",
     *                         example="Nama Mitra"
     *                     ),
     *                     @OA\Property(
     *                         property="jenis_identitas_mitra",
     *                         type="string",
     *                         example="KTP"
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Mitra gagal ditambah")
     *         )
     *     )
     * )
     */
    public function createMitra(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_mitra' => 'required|string|max:255',
            'jenis_identitas_mitra' => ['required', Rule::in(['KTP', 'NPWP', 'PASSPORT'])],
            'nomor_identitas_mitra' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas_mitra'))
            ],

            'alamat_mitra' => 'required|string|max:255',
            'telepon_mitra' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/',
            'negara' => ['required', new NegaraRule],
            'provinsi' => ['required_if:negara,99', new ProvinsiRule],
            'kabupaten_kota' => ['required_if:negara,99', new KotaRule(request()->input('provinsi'))],
        ]);
        if ($validate->fails()) {
            $error = [];
            foreach ($validate->errors()->toArray() as $key => $value) {
                $error[$key] = $value[0];
            }
            return ApiResponse::errorResponse('Validation failed', 422, $error);
        }
        $data = $request->merge([
            'master_negara_id' => $request->negara,
            'master_provinsi_id' => $request->provinsi,
            'master_kota_kab_id' => $request->kabupaten_kota,
            'pj_barantin_id' => request()->user()->barantin->id ?? null,
        ])->except('negara', 'provinsi', 'kabupaten_kota');

        $res = MitraPerusahaan::create($data);
        if ($res) {
            return ApiResponse::successResponse('Mitra pengguna jasa berhasil dibuat', self::renderDataResponse($res), false);
        }
        return ApiResponse::errorResponse('Mitra pengguna jasa gagal dibuat', 404);

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
            "barantin_id" => $data->barantin->id ?? null,
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
