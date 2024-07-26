<?php

namespace App\Http\Controllers\User;

use App\Rules\UptRule;
use App\Models\Register;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Rules\UptUserCheckRule;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserUptController extends Controller
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
        return view('user.upt.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('user.upt.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // validasi upt
        $request->validate([
            'upt' => [
                'required',
                new UptRule,
                new UptUserCheckRule(auth()->user()->barantin->id)
            ],
        ]);

        foreach ($request->upt as $value) {
            $res = Register::updateOrCreate(
                [
                    'master_upt_id' => $value,
                    'pj_barantin_id' => auth()->user()->barantin->id ?? null,
                ],
                [
                    'status' => 'MENUNGGU',
                    'pre_register_id' => auth()->user()->barantin->pre_register_id,
                ]
            );
        }
        if ($res) {
            return AjaxResponse::SuccessResponse('Upt berhasil diajukan', 'user-upt-datatable');
        }
        return AjaxResponse::ErrorResponse('Upt gagal diajukan', 400);

    }
    public function datatable(): JsonResponse
    {
        $model = $this->query();
        return DataTables::eloquent($model)
            ->addColumn('upt', function ($row) {
                $upt = BarantinApiHelper::getMasterUptByID($row->master_upt_id);
                return $upt['nama_satpel'] . ' - ' . $upt['nama'];
            })
            ->filterColumn('upt', function ($query, $keyword) {
                $upt = collect(BarantinApiHelper::getDataMasterUpt()->original);
                $idUpt = JsonFilterHelper::searchDataByKeyword($upt, $keyword, 'nama_satpel', 'nama')->pluck('id');
                $query->whereIn('master_upt_id', $idUpt);
            })
            ->addIndexColumn()->make(true);
    }
    // query model
    public function query()
    {
        return Register::whereHas('barantin', function ($query) {
            $query->where('id', auth()->user()->barantin->id);
        })->select('registers.id', 'pj_barantin_id', 'registers.status', 'registers.keterangan', 'master_upt_id', 'blockir', 'registers.updated_at', 'registers.created_at');
    }
}
