<?php

namespace App\Http\Controllers\User;

use App\Models\Register;
use App\Models\PjBarantin;
use App\Models\PreRegister;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\DokumenPendukung;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\UserRequestCabangStore;
use App\Http\Requests\DokumenPendukungRequestStore;

class UserCabangController extends Controller
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
        return view('user.cabang.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $register = PreRegister::create([
            'pemohon' => 'perusahaan',
            'verify_email' => now(),
            'jenis_perusahaan' => 'cabang',
        ]);
        return view('user.cabang.create', compact('register'));
    }

    public function store(UserRequestCabangStore $request): JsonResponse
    {
        $dokumen = DokumenPendukung::where('pre_register_id', $request->id_pre_register)->pluck('jenis_dokumen');

        if ($dokumen->contains('NITKU')) {
            $request->merge([
                'negara_id' => 99,
                'nama_alias_perusahaan' => $request->nama_alias_perusahaan,
                'provinsi_id' => $request->provinsi,
                'pre_register_id' => $request->id_pre_register,
                'lingkup_aktifitas' => implode(',', $request->lingkup_aktivitas),
                'jenis_identitas' => auth()->user()->barantin->jenis_identitas,
                'nomor_identitas' => auth()->user()->barantin->nomor_identitas,
            ]);

            $data = $request->except(['upt', 'negara', 'provinsi', 'identifikasi_perusahaan','ketentuan']);

            $this->SaveRegisterCabang($request->upt, $data);
            return response()->json(['status' => true, 'message' => 'Cabang berhasil dibuat silahkan tunggu konfirmasi upt yang dipilih']);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen  NITKU'], 422);
    }
    public function SaveRegisterCabang(array $upt, array $data): bool
    {
        DB::transaction(
            function () use ($data, $upt) {
                $cabang = PjBarantin::create($data);
                PreRegister::find($data['pre_register_id'])->update(['nama' => $cabang->nama_perusahaan, 'email' => $cabang->email]);
                foreach ($upt as $value) {
                    Register::create(['master_upt_id' => $value, 'pj_barantin_id' => $cabang->id, 'status' => 'MENUNGGU', 'pre_register_id' => $data['pre_register_id']]);
                }
                DokumenPendukung::where('pre_register_id', $data['pre_register_id'])->update(['pj_barantin_id' => $cabang->id, 'pre_register_id' => null]);
            }
        );
        return true;
    }

    public function cancel(Request $request): JsonResponse
    {
        $request->validate(['id_pre_register' => 'required|exists:pre_registers,id']);
        $res = PreRegister::destroy($request->id_pre_register);
        if ($res) {
            return AjaxResponse::SuccessResponse('Pembuatan cabang sukses dibatalkan', 'user-cabang-datatable');
        }
        return AjaxResponse::ErrorResponse('Pembuatan cabang gagal dibatalkan', 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = PjBarantin::find($id);
        return view('user.cabang.show', compact('data'));
    }

    public function datatable(): JsonResponse
    {
        $model = $this->query();
        return DataTables::eloquent($model)->addIndexColumn()
            ->addColumn('negara', function ($row) {
                $negara = BarantinApiHelper::getMasterNegaraByID($row->negara_id);
                return $negara['nama'];
            })
            ->filterColumn('negara', function ($query, $keyword) {
                $negara = collect(BarantinApiHelper::getDataMasterNegara()->original);
                $idNegara = JsonFilterHelper::searchDataByKeyword($negara, $keyword, 'nama')->pluck('id');
                $query->whereIn('negara_id', $idNegara);
            })
            ->addColumn('provinsi', function ($row) {
                $provinsi = BarantinApiHelper::getMasterProvinsiByID($row->provinsi_id);
                return $provinsi['nama'];
            })
            ->filterColumn('provinsi', function ($query, $keyword) {
                $provinsi = collect(BarantinApiHelper::getDataMasterProvinsi()->original);
                $idProvinsi = JsonFilterHelper::searchDataByKeyword($provinsi, $keyword, 'nama')->pluck('id');
                $query->whereIn('provinsi_id', $idProvinsi);
            })
            ->addColumn('kota', function ($row) {
                $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($row->kota, $row->provinsi_id);
                return $kota['nama'];
            })
            ->filterColumn('kota', function ($query, $keyword) {
                $kota = collect(BarantinApiHelper::getDataMasterKota()->original);
                $idKota = JsonFilterHelper::searchDataByKeyword($kota, $keyword, 'nama')->pluck('id');
                $query->whereIn('kota', $idKota);

            })
            ->addColumn('action', 'user.cabang.action')->make(true);
    }
    public function query()
    {
        return PjBarantin::select(
            'id',
            'email',
            'nama_perusahaan',
            'jenis_identitas',
            'nomor_identitas',
            'alamat',
            'nitku',
            'kota',
            'provinsi_id',
            'negara_id',
            'telepon',
            'fax',
            'status_import',
            'user_id'
        )
            ->where('nomor_identitas', auth()->user()->barantin->nomor_identitas)
            ->whereNot('nitku', '000000');
    }


    // dokumen pendukung create handler
    public function DokumenPendukungStore(string $id, DokumenPendukungRequestStore $request): JsonResponse
    {
        $file = Storage::disk('public')->put('file_pendukung/' . $id, $request->file('file_dokumen'));
        $data = $request->only(['jenis_dokumen', 'nomer_dokumen', 'tanggal_terbit']);
        $data = collect($data)->merge(['pre_register_id' => $id, 'file' => $file]);

        $dokumen = DokumenPendukung::create($data->all());

        if ($dokumen) {
            return AjaxResponse::SuccessResponse('dokumen pendukung berhasil ditambah', 'datatable-dokumen-pendukung');
        }
        return AjaxResponse::ErrorResponse('dokumen pendukung gagal ditambah', 200);

    }
    public function DokumenPendukungDataTable(string $id, Request $request): JsonResponse
    {
        if ($request->response === 'create') {
            $model = DokumenPendukung::where('pre_register_id', $id);
        } else {
            $model = DokumenPendukung::where('pj_barantin_id', $id);
        }

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('action', 'user.cabang.action-pendukung')
            ->editColumn('file', 'user.cabang.file-pendukung')
            ->rawColumns(['action', 'file'])
            ->toJson();
    }
    public function DokumenPendukungDestroy(string $id): JsonResponse
    {

        $data = DokumenPendukung::find($id);
        Storage::disk('public')->delete($data->file);
        $res = $data->delete();

        if ($res) {
            return AjaxResponse::SuccessResponse('dokumen pendukung berhasil dihapus', 'datatable-dokumen-pendukung');
        }
        return AjaxResponse::ErrorResponse('dokumen pendukung gagal dihapus', 200);
    }

    public function DatatableUptDetail(string $id): JsonResponse
    {
        $model = Register::where('pj_barantin_id', $id);
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('upt', function ($row) {
                $upt = BarantinApiHelper::getMasterUptByID($row->master_upt_id);
                return $upt['nama_satpel'] . ' - ' . $upt['nama'];
            })
            ->filterColumn('upt', function ($query, $keyword) {
                $upt = collect(BarantinApiHelper::getDataMasterUpt()->original);
                $idUpt = JsonFilterHelper::searchDataByKeyword($upt, $keyword, 'nama_satpel', 'nama')->pluck('id');
                $query->whereIn('master_upt_id', $idUpt);
            })
            ->toJson();
    }
    // public function confirmasi(Request $request, string $cabang_id): JsonResponse
    // {
    //     $request->validate([
    //         'status' => 'required|in:DISETUJUI,DITOLAK',
    //     ]);
    //     $res = PjBarantin::find($cabang_id)->update(['persetujuan_induk' => $request->status]);
    //     if ($res) {
    //         return AjaxResponse::SuccessResponse('cabang berhasil disetujui', 'user-cabang-datatable');
    //     }
    //     return AjaxResponse::ErrorResponse('cabang gagal disetujui', 200);
    // }
}
