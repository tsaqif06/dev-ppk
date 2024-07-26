<?php

namespace App\Http\Controllers\User;

use App\Models\Ppjk;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserPppjkRequestStore;
use App\Http\Requests\UserPppjkRequestUpdate;

class UserPpjkController extends Controller
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
        return view('user.ppjk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.ppjk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserPppjkRequestStore $request)
    {

        $data = $request->merge([
            'master_negara_id' => 99,
            'master_provinsi_id' => $request->provinsi,
            'master_kota_kab_id' => $request->kabupaten_kota,
            'pj_barantin_id' => auth()->user()->barantin->id,
        ])->except(['provinsi', 'kabupaten_kota']);
        $res = Ppjk::create($data);
        if ($res) {
            return AjaxResponse::SuccessResponse('Ppjk berhasil ditambah', 'user-ppjk-datatable');
        }
        return AjaxResponse::ErrorResponse('Ppjk gagal ditambah', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Ppjk::find($id);
        return view('user.ppjk.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = Ppjk::find($id);
        return view('user.ppjk.edit', compact('data'));


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserPppjkRequestUpdate $request, string $id)
    {
        $data = $request->merge([
            'master_provinsi_id' => $request->provinsi,
            'master_kota_kab_id' => $request->kabupaten_kota,
        ])->except(['provinsi', 'kabupaten_kota', '_method']);

        $res = Ppjk::find($id)->update($data);

        if ($res) {
            return AjaxResponse::SuccessResponse('Ppjk berhasil diupdate', 'user-ppjk-datatable');
        }
        return AjaxResponse::ErrorResponse('Ppjk gagal diupdate', 400);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $res = Ppjk::destroy($id);
        if ($res) {
            return AjaxResponse::SuccessResponse('Ppjk berhasil dihapus', 'user-ppjk-datatable');
        }
        return AjaxResponse::ErrorResponse('Ppjk gagal dihapus', 400);
    }
    public function datatable(): JsonResponse
    {
        $model = $this->query();
        return DataTables::eloquent($model)->addIndexColumn()
            ->addColumn('action', 'user.ppjk.action')
            ->addColumn('negara', function ($row) {
                $negara = BarantinApiHelper::getMasterNegaraByID($row->master_negara_id);
                return $negara['nama'];
            })
            ->filterColumn('negara', function ($query, $keyword) {
                $negara = collect(BarantinApiHelper::getDataMasterNegara()->original);
                $idNegara = JsonFilterHelper::searchDataByKeyword($negara, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('master_negara_id', $idNegara));
            })
            ->addColumn('provinsi', function ($row) {
                $provinsi = BarantinApiHelper::getMasterProvinsiByID($row->master_provinsi_id);
                return $provinsi['nama'];
            })
            ->filterColumn('provinsi', function ($query, $keyword) {
                $provinsi = collect(BarantinApiHelper::getDataMasterProvinsi()->original);
                $idProvinsi = JsonFilterHelper::searchDataByKeyword($provinsi, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('master_provinsi_id', $idProvinsi));
            })
            ->addColumn('kota', function ($row) {
                $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($row->master_kota_kab_id, $row->master_provinsi_id);
                return $kota['nama'];
            })
            ->filterColumn('kota', function ($query, $keyword) {
                $kota = collect(BarantinApiHelper::getDataMasterKota()->original);
                $idKota = JsonFilterHelper::searchDataByKeyword($kota, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('master_kota_kab_id', $idKota));

            })
            ->make(true);
    }
    public function query()
    {
        $select = Ppjk::select(
            'ppjks.id',
            'nama_ppjk',
            'email_ppjk',
            'tanggal_kerjasama_ppjk',
            'alamat_ppjk',
            'master_negara_id',
            'master_provinsi_id',
            'master_kota_kab_id',
            'pj_barantin_id',
            'status_ppjk'
        );
        return $select->where('pj_barantin_id', auth()->user()->barantin->id);

    }
}

