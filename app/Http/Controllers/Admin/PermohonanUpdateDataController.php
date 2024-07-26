<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\DokumenPendukung;
use App\Models\PengajuanUpdatePj;
use Illuminate\Http\JsonResponse;
use App\Mail\MailUpdatePersetujuan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailPenolakanUpdateData;
use App\Mail\MailSendLinkForUpdatePj;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PermohonanUpdateDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('ajax')->except('index');
    }
    public function index()
    {
        if (request()->ajax()) {
            return $this->datatable();
        }
        return view('admin.permohonan-update.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function confirmUpdate(Request $request, string $pengajuan_id)
    {
        $request->validate([
            'persetujuan' => 'required|in:disetujui,ditolak'
        ]);

        $data = PengajuanUpdatePj::find($pengajuan_id);
        $namaPerusahaan = $data->barantin->nama_perusahaan ?? null;
        $email = $data->barantin->email ?? null;
        if ($request->persetujuan === 'ditolak') {
            $data->update(['persetujuan' => 'ditolak', 'status_update' => 'gagal']);
            Mail::to($email)->send(new MailPenolakanUpdateData);
            return AjaxResponse::SuccessResponse("Perubahan data {$namaPerusahaan} ditolak", 'permohonan-update-datatable');
        }
        $token = md5($namaPerusahaan . now() . env('UPDATE_TOKEN_KEY', 'B4rantinK3yS3Cret'));
        $data->update(['persetujuan' => 'disetujui', 'update_token' => $token, 'expire_at' => now()->addDay()]);
        $idBarantin = $data->barantin->id ?? $data->barantincabang->id ?? null;
        Mail::to($email)->send(new MailSendLinkForUpdatePj($idBarantin, $token));
        return AjaxResponse::SuccessResponse("Perubahan data {$namaPerusahaan} disetujui", 'permohonan-update-datatable');
    }
    public function datatable()
    {
        $model = PengajuanUpdatePj::with(
            'barantin:id,pre_register_id,nama_perusahaan,jenis_perusahaan',
            'barantin.preregister:id,pemohon,jenis_perusahaan',
        )->select('pengajuan_update_pjs.*');
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('action', 'admin.permohonan-update.action')
            ->make(true);
    }
    public function show(string $id)
    {
        if (request()->input('datatable')) {
            return $this->datatablePendukung($id);
        }
        $data = PengajuanUpdatePj::find($id);
        $view = 'admin.permohonan-update.show.perorangan';
        if ($data->barantin->preregister->pemohon == 'perusahaan') {
            $view = 'admin.permohonan-update.show.perusahaan';
        }
        return view($view, compact('data'));

    }
    public function datatablePendukung(string $id): JsonResponse
    {

        $model = DokumenPendukung::where('pengajuan_update_pj_id', $id);
        if (!$model->exists()) {
            $pengajuan = PengajuanUpdatePj::find($id);
            $model = $model->orWhere('pj_barantin_id', $pengajuan->pj_barantin_id);
        }
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('file', 'register.form.partial.file_pendukung_datatable')
            ->rawColumns(['action', 'file'])
            ->make(true);
    }
    public function updateData(string $pengajuan_id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak'
        ]);
        // dd($request->all());
        $pengajuan = PengajuanUpdatePj::find($pengajuan_id);

        if ($request->status == 'ditolak') {
            return $this->ditolak($pengajuan);
        }
        return $this->disetujui($pengajuan);

    }
    public function ditolak(PengajuanUpdatePj $pengajuan)
    {
        $pengajuan->update(['persetujuan' => 'ditolak', 'status_update' => 'gagal']);
        Mail::to($pengajuan->barantin->email)->send(new MailPenolakanUpdateData);
        return AjaxResponse::SuccessResponse("Perubahan data {$pengajuan->barantin->email} ditolak", 'permohonan-update-datatable');
    }
    public function disetujui(PengajuanUpdatePj $pengajuan)
    {
        $pengajuan->update(['persetujuan' => 'disetujui', 'status_update' => 'selesai']);
        $data = json_decode($pengajuan->temp_update, true);
        $pengajuan->barantin()->update(collect($data)->except('lingkup_aktivitas', '_method')->all());
        foreach ($pengajuan->dokumenpendukung as $index => $value) {
            $dokumen = DokumenPendukung::where('pj_barantin_id', $pengajuan->pj_barantin_id)->first();
            if ($dokumen) {
                Storage::disk('public')->delete($dokumen->file);
            }
            DokumenPendukung::find($value->id)->update(['pj_barantin_id' => $pengajuan->pj_barantin_id, 'pengajuan_update_pj_id' => null]);
        }
        Mail::to($pengajuan->barantin->email)->send(new MailUpdatePersetujuan);
        return AjaxResponse::SuccessResponse("Perubahan data {$pengajuan->barantin->nama_perusahaan} disetujui", 'permohonan-update-datatable');
    }
}
