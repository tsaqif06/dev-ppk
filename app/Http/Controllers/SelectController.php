<?php

namespace App\Http\Controllers;

use App\Models\Register;
use App\Models\PjBarantin;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use App\Http\Controllers\Controller;

class SelectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function SelectUpt(): JsonResponse
    {
        $data = collect(BarantinApiHelper::getDataMasterUpt()->original);

        if (request()->input('q')) {
            $data = JsonFilterHelper::searchDataByKeyword($data, request()->input('q'), 'nama_satpel', 'nama');
        } elseif (request()->input('upt_id')) {
            $data = BarantinApiHelper::getMasterUptByID(request()->input('upt_id'));
        } elseif (request()->input('pre_register_id')) {
            $uptIdArray = Register::where('pre_register_id', request()->input('pre_register_id'))->pluck('master_upt_id')->toArray();
            $data = JsonFilterHelper::filterByID($data, $uptIdArray);
        }
        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function SelectNegara(): JsonResponse
    {
        $data = collect(BarantinApiHelper::GetDataMasterNegara()->original);
        if (request()->input('negara_id')) {
            $data = BarantinApiHelper::getMasterNegaraByID(request()->input('negara_id'));
        }
        return response()->json($data);
    }
    public function SelectProvinsi(): JsonResponse
    {
        $data = collect(BarantinApiHelper::getDataMasterProvinsi()->original);
        if (request()->input('provinsi_id')) {
            $data = BarantinApiHelper::getMasterProvinsiByID(request()->input('provinsi_id'));
        }
        return response()->json($data);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  */
    public function SelectKota(string $id): JsonResponse
    {
        $data = collect(BarantinApiHelper::getDataMasterKotaByProvinsi($id)->original);
        if (request()->input('kota_id')) {
            $data = BarantinApiHelper::getMasterKotaByIDProvinsiID(request()->input('kota_id'), $id);
        }
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     */
    public function SelectPerusahaanInduk()
    {
        $pj_barantin_id = Register::where('status', 'DISETUJUI')->distinct('pj_barantin_id')->pluck('pj_barantin_id');


        $perushaan = PjBarantin::select('id', 'nama_perusahaan')->whereIn('id', $pj_barantin_id)->get();

        return response()->json($perushaan);
    }
}
