<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\MitraPerusahaan;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserMitraRequestStore;
use App\Http\Requests\UserMitraRequestUpdate;

class UserMitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('ajax')->except('index');
    }
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return $this->datatable();
        }
        return view('user.mitra.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.mitra.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(UserMitraRequestStore $request)
    {
        $data = $request->merge([
            'master_negara_id' => $request->negara,
            'master_provinsi_id' => $request->provinsi,
            'master_kota_kab_id' => $request->kabupaten_kota,
            'pj_barantin_id' => auth()->user()->barantin->id ?? null,
        ])->except('negara', 'provinsi', 'kabupaten_kota');

        $res = MitraPerusahaan::create($data);
        if ($res) {
            return AjaxResponse::SuccessResponse('Mitra berhasil ditambah', 'user-mitra-datatable');
        }
        return AjaxResponse::ErrorResponse('Mitra gagal ditambah', 400);


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = MitraPerusahaan::find($id);

        return view('user.mitra.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = MitraPerusahaan::find($id);
        return view('user.mitra.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserMitraRequestUpdate $request, string $id)
    {
        $data = $request->merge([
            'master_negara_id' => $request->negara,
            'master_provinsi_id' => $request->provinsi,
            'master_kota_kab_id' => $request->kabupaten_kota,
        ])->except('negara', 'provinsi', 'kabupaten_kota', '_method');

        $res = MitraPerusahaan::find($id)->update($data);
        if ($res) {
            return AjaxResponse::SuccessResponse('Mitra berhasil diupdate', 'user-mitra-datatable');
        }
        return AjaxResponse::ErrorResponse('Mitra gagal diupdate', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = MitraPerusahaan::destroy($id);
        if ($res) {
            return AjaxResponse::SuccessResponse('Mitra berhasil dihapus', 'user-mitra-datatable');
        }
        return AjaxResponse::ErrorResponse('Mitra gagal dihapus', 400);
    }
    public function datatable(): JsonResponse
    {
        $model = $this->query();
        return DataTables::eloquent($model)->addIndexColumn()
            ->addColumn('negara', function ($row) {
                $negara = BarantinApiHelper::getMasterNegaraByID($row->master_negara_id ?? 0);
                return $negara['nama'] ?? null;
            })
            ->filterColumn('negara', function ($query, $keyword) {
                $negara = collect(BarantinApiHelper::getDataMasterNegara()->original);
                $idNegara = JsonFilterHelper::searchDataByKeyword($negara, $keyword, 'nama')->pluck('id');
                $query->whereIn('master_negara_id', $idNegara);
            })
            ->addColumn('provinsi', function ($row) {
                $provinsi = BarantinApiHelper::getMasterProvinsiByID($row->master_provinsi_id ?? 0);
                return $provinsi['nama'] ?? null;
            })
            ->filterColumn('provinsi', function ($query, $keyword) {
                $provinsi = collect(BarantinApiHelper::getDataMasterProvinsi()->original);
                $idProvinsi = JsonFilterHelper::searchDataByKeyword($provinsi, $keyword, 'nama')->pluck('id');
                $query->whereIn('master_provinsi_id', $idProvinsi);
            })
            ->addColumn('kota', function ($row) {
                $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($row->master_kota_kab_id ?? 0, $row->master_provinsi_id ?? 0);
                return $kota['nama'] ?? null;
            })
            ->filterColumn('kota', function ($query, $keyword) {
                $kota = collect(BarantinApiHelper::getDataMasterKota()->original);
                $idKota = JsonFilterHelper::searchDataByKeyword($kota, $keyword, 'nama')->pluck('id');
                $query->whereIn('master_kota_kab_id', $idKota);
            })
            ->addColumn('action', 'user.mitra.action')->make(true);
    }
    public function query()
    {
        $select = MitraPerusahaan::query();
        return $select->where('pj_barantin_id', auth()->user()->barantin->id);

    }
}
