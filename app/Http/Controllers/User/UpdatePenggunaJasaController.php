<?php

namespace App\Http\Controllers\User;

use App\Models\PjBarantin;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\DokumenPendukung;
use App\Models\PengajuanUpdatePj;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\RequestUpdatePerorangan;
use App\Http\Requests\RequestUpdatePerusahaan;
use App\Http\Requests\RequestUpdateDokumenPendukung;


class UpdatePenggunaJasaController extends Controller
{
    public function __construct()
    {
        $this->middleware('ajax')->except(['Message', 'UpdateIndex']);
    }
    public function Message(): View
    {
        return view('register.message');
    }
    public function UpdateIndex(string $barantin_id, string $token): View
    {
        return view('user.update.index', compact('barantin_id', 'token'));
    }
    public function UpdateForm(string $barantin_id, string $token): View
    {
        $data = PengajuanUpdatePj::where('update_token', $token)->where('pj_barantin_id', $barantin_id)->where('persetujuan', 'disetujui')->first();
        $view = $data->barantin->preregister->pemohon === 'perusahaan' ? 'user.update.partial.perusahaan' : 'user.update.partial.perorangan';
        return view($view, compact('data'));
    }

    public function StoreRegisterPerorangan(RequestUpdatePerorangan $request, string $id)
    {
        $dokumen = DokumenPendukung::where('pengajuan_update_pj_id', $id)->pluck('jenis_dokumen');
        $update = PengajuanUpdatePj::find($id);
        if ($dokumen->contains('KTP') || $dokumen->contains('PASSPORT')) {
            $data = self::inputRender($request);
            $update->update(['persetujuan' => 'menunggu', 'temp_update' => json_encode($data)]);
            return response()->json(['status' => true, 'message' => 'Update Perorangan berhasil dilakukan, Silahkan menunggu  email persetujuan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen KTP/PASSPORT'], 422);
    }
    public function StoreRegisterPerusahaan(RequestUpdatePerusahaan $request, string $id)
    {
        $dokumen = DokumenPendukung::where('pengajuan_update_pj_id', $id)->pluck('jenis_dokumen');
        $update = PengajuanUpdatePj::find($id);
        if ($update->barantin->preregister->jenis_perusahaan === 'induk') {
            return self::savePerusahaanInduk($dokumen, $request, $update);
        }
        return self::savePerusahaanCabang($dokumen, $request, $update);

    }
    private static function savePerusahaanInduk(Collection $dokumen, Request $request, PengajuanUpdatePj $update)
    {
        if ($dokumen->contains('NPWP') && $dokumen->contains('NIB')) {
            $data = self::inputRender($request);
            $update->update(['persetujuan' => 'menunggu', 'temp_update' => json_encode($data)]);
            return response()->json(['status' => true, 'message' => 'Update Perusahaan induk berhasil dilakukan, Silahkan menunggu  email persetujuan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen  NPWP, NIB'], 422);
    }
    private static function savePerusahaanCabang(Collection $dokumen, Request $request, PengajuanUpdatePj $update)
    {
        if ($dokumen->contains('NITKU')) {
            $data = self::inputRender($request);
            $update->update(['persetujuan' => 'menunggu', 'temp_update' => json_encode($data)]);
            return response()->json(['status' => true, 'message' => 'Update Perusahaan cabang berhasil dilakukan, Silahkan menunggu  email persetujuan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen  NITKU'], 422);
    }
    public static function inputRender(Request $request)
    {
        $request->merge([
            'negara_id' => 99,
            'nitku' => $request->nitku ?? '000000',
            'nama_alias_perusahaan' => $request->nama_alias_perusahaan,
            'provinsi_id' => $request->provinsi,
            'lingkup_aktifitas' => implode(',', $request->lingkup_aktivitas),
        ]);
        return $request->except(['upt', 'negara', 'provinsi', 'identifikasi_perusahaan', 'lingkup_aktivitas', '_method']);
    }

    public function DokumenPendukungStore(string $id, RequestUpdateDokumenPendukung $request): JsonResponse
    {
        $file = Storage::disk('public')->put('file_pendukung/' . $id, $request->file('file_dokumen'));
        $data = $request->only(['jenis_dokumen', 'nomer_dokumen', 'tanggal_terbit']);
        $data = collect($data)->merge(['pengajuan_update_pj_id' => $id, 'file' => $file]);

        $dokumen = DokumenPendukung::create($data->all());

        if ($dokumen) {
            return AjaxResponse::SuccessResponse('dokumen pendukung berhasil ditambah', 'datatable-dokumen-pendukung');
        }
        return AjaxResponse::ErrorResponse('dokumen pendukung gagal ditambah', 200);
    }


    public function DokumenPendukungDataTable(string $id): JsonResponse
    {
        $model = DokumenPendukung::where('pengajuan_update_pj_id', $id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('action', 'user.update.partial.action_pendukung_datatable')
            ->editColumn('file', 'user.update.partial.file_pendukung_datatable')
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
}
