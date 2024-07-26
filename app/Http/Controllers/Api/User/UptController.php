<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Register;
use App\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;

class UptController extends Controller
{
    /**
     * @OA\Get(
     *     path="/user/upt",
     *     summary="Ambil Semua User Upt di masing masing user",
     *     tags={"User"},
     *     security={{ "bearer_token": {} }},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
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
     *                             property="master_upt_id",
     *                             type="integer",
     *                             example=1
     *                         ),
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function getAllUptUser()
    {

        $data = Register::where('pj_barantin_id', auth('sanctum')->user()->barantin->id)->orderBy('created_at', 'desc');
        if ($data->exists()) {
            return ApiResponse::successResponse('Upt pengguna jasa berhasil ditemukan', self::renderResponseUpts($data->get()), false);
        }
        return ApiResponse::errorResponse('Data not found', 404);
    }

    private static function renderResponseUpts($data)
    {
        $dataArray = [];
        foreach ($data as $value) {
            $dataArray = self::renderResponseUpt($value);
        }
        return $dataArray;
    }
    private static function renderResponseUpt($data)
    {
        $upt = BarantinApiHelper::getMasterUptByID($data->master_upt_id);
        return [
            'register_id' => $data->id,
            'nama_upt' => $upt['nama_satpel'] . ' - ' . $upt['nama'],
            'status' => $data->status,
            'tanggal_pengajuan' => date('Y-m-d', strtotime($data->created_at)),
            'tanggal_persetujuan' => date('Y-m-d', strtotime($data->updated_at)),
            'keterangan' => $data->keterangan,
            'blockir' => $data->blockir == 0 ? 'TIDAK AKTIF' : 'AKTIF',
        ];
    }
}
