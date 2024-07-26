<?php

namespace App\Http\Controllers\Api;

use App\Models\Register;
use App\Models\PjBarantin;
use App\Helpers\ApiResponse;
use App\Helpers\PaginationHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinAPIHelper;
use App\Helpers\StatusImportHelper;
use App\Http\Controllers\Controller;

class BarantinController extends Controller
{

    private $uptPusatId;
    public function __construct()
    {
        $this->uptPusatId = env('UPT_PUSAT_ID', 1000);
    }
    /**
     * @OA\Get(
     *     path="/barantin/{take}",
     *     tags={"Barantin Admin"},
     *     summary="Dapatkan Data Barantin",
     *     description="Mengambil data Barantin menggunakan parameter take",
     *     operationId="getAllDataBarantin",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="take",
     *         in="path",
     *         description="Jumlah data yang akan diambil",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="barantin data by id"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="nama", type="string", example="John Doe"),
     *                 @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                 @OA\Property(property="no_hp", type="string", example="08123456789"),
     *                 @OA\Property(property="alamat", type="string", example="Jl. Sudirman No. 123"),
     *                 @OA\Property(property="created_at", type="string", example="2023-02-28 12:34:56"),
     *                 @OA\Property(property="updated_at", type="string", example="2023-02-28 12:34:56")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="data not found")
     *         )
     *     )
     * )
     */
    public function getAllDataBarantin(int $take)
    {

        $data = Register::with('preregister', 'barantin')
            ->select('registers.*')
            ->where('status', 'DISETUJUI')
            ->where('blockir', 0);

        if (request()->user()->upt_id != $this->uptPusatId) {
            $data = $data->where('master_upt_id', request()->user()->upt_id);
        }

        if ($data->exists()) {
            return ApiResponse::successResponse('barantin data', self::renderResponseDataBarantins($data->paginate($take), true, ), true);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }

    /**
     * @OA\Get(
     *     path="/barantin/{npwp}/cabang",
     *     tags={"Barantin Admin"},
     *     summary="Dapatkan Data Barantin Perusahaan Cabang",
     *     description="Mengambil data Barantin Perusahaan Cabang",
     *     operationId="getAllDataBarantinPerusahaanCabang",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         name="npwp",
     *         in="path",
     *         description="Jumlah data yang ingin diambil",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="barantin data perusahaan cabang"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="nama", type="string", example="John Doe"),
     *                     @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *                     @OA\Property(property="no_hp", type="string", example="08123456789"),
     *                     @OA\Property(property="alamat", type="string", example="Jl. Sudirman No. 123"),
     *                     @OA\Property(property="created_at", type="string", example="2023-02-28 12:34:56"),
     *                     @OA\Property(property="updated_at", type="string", example="2023-02-28 12:34:56")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Data Not Found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="data not found")
     *         )
     *     )
     * )
     */
    public function getAllDataBarantinPerusahaanCabang(int $npwp)
    {
        $data = Register::with('preregister', 'barantin')
            ->select('registers.*')
            ->whereHas('preregister', fn($query) => $query->where('jenis_perusahaan', 'cabang'))
            ->whereHas('barantin', fn($query) => $query->where('nomor_identitas', $npwp))
            ->whereHas('barantin', fn($query) => $query->where('nitku', '!=', '000000'))
            ->where('status', 'DISETUJUI')
            ->where('blockir', 0);
        if (request()->user()->upt_id != $this->uptPusatId) {
            $data = $data->where('master_upt_id', request()->user()->upt_id);
        }
        if ($data->exists()) {
            return ApiResponse::successResponse('barantin data perusahaan cabang', self::renderResponseDataBarantins($data->get(), false), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }



    /**
     * @OA\Get(
     *     path="/barantin/{register_id}/register",
     *     tags={"Barantin Admin"},
     *     summary="Get Barantin Data By Register ID",
     *     description="Get Barantin Data By Register ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Register ID",
     *         in="path",
     *         name="register_id",
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
    public function getDataBarantinByRegisterID(string $register_id): JsonResponse
    {
        $data = Register::find($register_id);

        if ($data) {
            return ApiResponse::successResponse('barantin data by register id', self::renderResponseDataBarantin($data), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }
    /**
     * @OA\Get(
     *     path="/barantin/{barantin_id}/detil",
     *     tags={"Barantin Admin"},
     *     summary="Get Barantin Data Detail By Barantin ID",
     *     description="Get Barantin Data Detail By Barantin ID",
     *     security={{"bearer_token":{}}},
     *     @OA\Parameter(
     *         description="Barantin ID",
     *         in="path",
     *         name="barantin_id",
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
    public function detilDataBarantinById(string $barantin_id)
    {
        $data = PjBarantin::with(['preregister'])->find($barantin_id);
        if ($data) {
            return ApiResponse::successResponse('barantin detail data', self::renderResponseDataBarantinDetil($data, 'induk'), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }


    /**
     * Merender data Barantin menjadi format response yang sesuai.
     * Jika pagination diaktifkan, akan menerapkan pagination pada response.
     *
     * @param array $data Data Barantin yang akan dirender.
     * @param bool $pagination Menentukan apakah pagination harus diterapkan.
     * @return array Array yang berisi data Barantin yang sudah dirender.
     */
    private static function renderResponseDataBarantins($data, bool $pagination)
    {
        $response = [];
        foreach ($data as $index => $item) {
            $response[$index] = self::renderResponseDataBarantin($item);
        }

        if ($pagination) {
            $response = PaginationHelper::pagination($data, $response);
        }

        return $response;
    }
    /**
     * Merender data Barantin menjadi format response yang sesuai.
     * Mengambil data provinsi dan kota dari helper dan memformatnya ke dalam response.
     *
     * @param object $data Objek data Barantin yang akan dirender.
     * @return array Array yang berisi data Barantin yang sudah diformat.
     */
    private static function renderResponseDataBarantin($data)
    {
        $provinsi = BarantinApiHelper::getMasterProvinsiByID($data->barantin->provinsi_id);
        $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($data->barantin->kota, $data->barantin->provinsi_id);
        $upt = BarantinApiHelper::getMasterUptByID($data->master_upt_id);


        $dataArray = [
            'register_id' => $data->id ?? null,
            'barantin_id' => $data->barantin->id ?? null,
            'upt' => $upt['nama_satpel'] . ' - ' . $upt['nama'] ?? null,
            'kode_perusahaan' => $data->barantin->kode_perusahaan ?? null,
            'pemohon' => $data->preregister->pemohon ?? null,
            'identifikasi_perusahaan' => $data->preregister->jenis_perusahaan ?? 'perorangan',
            'jenis_perusahaan' => $data->barantin->jenis_perusahaan ?? null,
            'nama_perusahaan' => $data->barantin->nama_perusahaan ?? null,
            'nama_alias_perusahaan' => $data->barantin->nama_alias_perusahaan ?? null,
            'jenis_identitas' => $data->barantin->jenis_identitas ?? null,
            'nomor_identitas' => $data->barantin->nomor_identitas ?? null,
            'NITKU' => $data->barantin->nitku ?? '000000',
            'alamat' => $data->barantin->alamat ?? null,
            'provinsi' => $provinsi ? $provinsi['nama'] : null,
            'kota' => $kota ? $kota['nama'] : null,
            'telepon' => $data->barantin->telepon ?? null,
            'email' => $data->barantin->email ?? null,
            'fax' => $data->barantin->fax ?? null,

            'nama_cp' => $data->barantin->nama_cp ?? null,
            'alamat_cp' => $data->barantin->alamat_cp ?? null,
            'telepon_cp' => $data->barantin->telepon_cp ?? null,

            'nama_tdd' => $data->barantin->nama_tdd ?? null,
            'jenis_identitas_tdd' => $data->barantin->jenis_identitas_tdd ?? null,
            'nomor_identitas_tdd' => $data->barantin->nomor_identitas_tdd ?? null,
            'jabatan_tdd' => $data->barantin->jabatan_tdd ?? null,
            'alamat_tdd' => $data->barantin->alamat_tdd ?? null,

            'status_import' => StatusImportHelper::statusRender($data->barantin->status_import),
            'lingkup_aktifitas' => StatusImportHelper::aktifitasRender($data->barantin->lingkup_aktifitas),
        ];


        return $dataArray;

    }
    private static function renderResponseDataBarantinDetil($data, $jenisPerusahaan)
    {
        $provinsi = BarantinApiHelper::getMasterProvinsiByID($data->provinsi_id);
        $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($data->kota, $data->provinsi_id);

        $dataArray = [
            $jenisPerusahaan == 'cabang' ? 'barantin_cabang_id' : 'barantin_id' => $data->id,
            'kode_perusahaan' => $data->kode_perusahaan,
            'pemohon' => $data->preregister->pemohon,
            'identifikasi_perusahaan' => $data->preregister->jenis_perusahaan ?? 'perorangan',
            'jenis_perusahaan' => $data->jenis_perusahaan,
            'nama_perusahaan' => $data->nama_perusahaan,
            'nama_alias_perusahaan' => $data->nama_alias_perusahaan,
            'jenis_identitas' => $data->jenis_identitas,
            'nomor_identitas' => $data->nomor_identitas,
            'NITKU' => $data->nitku ?? '000000',
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

        return $dataArray;

    }
    private static function insertAfterKey($array, $key, $newKey, $newValue)
    {
        $newArray = [];
        $inserted = false;

        foreach ($array as $k => $v) {
            $newArray[$k] = $v;
            if ($k === $key) {
                $newArray[$newKey] = $newValue;
                $inserted = true;
            }
        }
        if (!$inserted) {
            $newArray[$newKey] = $newValue;
        }
        return $newArray;
    }
}
