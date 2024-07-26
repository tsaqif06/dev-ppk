<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Register;
use App\Models\PjBarantin;
use App\Models\PreRegister;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\BarantinCabang;
use App\Models\DokumenPendukung;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Database\Eloquent\Builder;

class PermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $uptPusatId;
    public function __construct()
    {
        $this->middleware('ajax')->except('index');
        $this->uptPusatId = env('UPT_PUSAT_ID', 1000);
    }
    public function index(): View|JsonResponse
    {
        if (request()->ajax()) {
            return $this->datatable();
        }
        return view('admin.permohonan.index');
    }

    /**
     * Menampilkan detail permohonan berdasarkan ID.
     *
     * Metode ini mengambil data permohonan menggunakan ID yang diberikan.
     * Jika pemohon adalah perorangan, tampilkan view perorangan.
     * Jika pemohon adalah perusahaan induk atau tidak memiliki jenis, tampilkan view induk.
     * Jika tidak, tampilkan view cabang.
     *
     * @param Request $request Request yang dikirim oleh user.
     * @param string $id ID dari permohonan yang ingin ditampilkan.
     * @return View Mengembalikan view yang sesuai dengan jenis pemohon.
     */
    public function show(Request $request, string $id): View
    {
        $register = Register::find($id);
        $data = $register->barantin;
        $preregister = $register->preregister;
        $upt = BarantinApiHelper::getMasterUptByID($register->master_upt_id);

        $view = 'admin.permohonan.show.perorangan';

        if ($preregister->pemohon === 'perusahaan') {
            $view = 'admin.permohonan.show.perusahaan';
        }
        return view($view, compact('data', 'register'));
    }


    /**
     * Menghapus entri permohonan dari database.
     *
     * Fungsi ini bertanggung jawab untuk menghapus entri permohonan berdasarkan ID yang diberikan.
     * Jika penghapusan berhasil, fungsi akan mengembalikan response sukses.
     * Jika penghapusan gagal, fungsi akan mengembalikan response error.
     *
     * @param string $id ID dari permohonan yang akan dihapus.
     * @return JsonResponse yang mengindikasikan hasil operasi.
     */
    public function destroy(string $id): JsonResponse
    {
        $res = Register::destroy($id);
        if ($res) {
            return AjaxResponse::SuccessResponse('Permohonan berhasil dihapus', 'permohonan-datatable');
        }
        return AjaxResponse::ErrorResponse($res, 400);
    }
    /**
     * Menghasilkan JSON response untuk DataTable berdasarkan jenis pemohon.
     *
     * Metode ini mengambil model yang sesuai berdasarkan jenis pemohon, kemudian
     * membangun DataTable yang memungkinkan pencarian berdasarkan tanggal update.
     * Kolom dan aksi spesifik ditambahkan melalui metode `columnDaerahRender`.
     *
     * @param string $pemohon Tipe pemohon yang digunakan untuk memfilter data.
     * @return JsonResponse Response DataTable yang siap digunakan di frontend.
     */
    public function datatable(): JsonResponse
    {
        $model = $this->queryRegister();
        $uptId = auth()->guard('admin')->user()->upt_id;
        if ($uptId != $this->uptPusatId) {
            $model = $model->where('master_upt_id', $uptId);
        }
        $datatable = DataTables::eloquent($model)->addIndexColumn();

        return $this->columnDaerahRender($datatable);

    }

    /**
     * Menambahkan kolom-kolom daerah dan aksi ke DataTable.
     *
     * Metode ini menambahkan kolom UPT, negara, provinsi, dan kota berdasarkan ID yang terkait
     * dari model yang diberikan. Kolom aksi juga ditambahkan berdasarkan parameter yang diterima.
     *
     * @param mixed $datatable DataTable yang sedang dibangun.
     * @param string $action Nama view untuk kolom aksi.
     * @return mixed DataTable yang telah dimodifikasi dengan kolom tambahan.
     */
    private function columnDaerahRender($datatable)
    {
        return $datatable->addColumn('upt', function ($row) {
            $upt = BarantinApiHelper::getMasterUptByID($row->master_upt_id);
            return $upt['nama_satpel'] . ' - ' . $upt['nama'];
        })
            ->addColumn('negara', function ($row) {
                $negara = BarantinApiHelper::getMasterNegaraByID($row->barantin->negara_id);
                return $negara['nama'] ?? null;
            })
            ->filterColumn('negara', function ($query, $keyword) {
                $negara = collect(BarantinApiHelper::getDataMasterNegara()->original);
                $idNegara = JsonFilterHelper::searchDataByKeyword($negara, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('negara_id', $idNegara));
            })
            ->addColumn('provinsi', function ($row) {
                $provinsi = BarantinApiHelper::getMasterProvinsiByID($row->barantin->provinsi_id);
                return $provinsi['nama'] ?? null;
            })
            ->filterColumn('provinsi', function ($query, $keyword) {
                $provinsi = collect(BarantinApiHelper::getDataMasterProvinsi()->original);
                $idProvinsi = JsonFilterHelper::searchDataByKeyword($provinsi, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('provinsi_id', $idProvinsi));
            })
            ->addColumn('kota', function ($row) {
                $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($row->barantin->kota, $row->barantin->provinsi_id);
                return $kota['nama'] ?? null;
            })
            ->filterColumn('kota', function ($query, $keyword) {
                $kota = collect(BarantinApiHelper::getDataMasterKota()->original);
                $idKota = JsonFilterHelper::searchDataByKeyword($kota, $keyword, 'nama')->pluck('id');
                $query->whereHas('barantin', fn($query) => $query->whereIn('kota', $idKota));
            })->filterColumn('updated_at', function ($query, $keyword) {
                $range = explode(' - ', $keyword);
                if (count($range) === 2) {
                    $startDate = Carbon::parse($range[0])->startOfDay();
                    $endDate = Carbon::parse($range[1])->endOfDay();
                    $query->whereBetween('registers.updated_at', [$startDate, $endDate]);
                }
            })
            ->addColumn('action', 'admin.permohonan.action')->make(true);
    }



    /**
     * Membuat query untuk mengambil data registrasi perorangan dan induk.
     * Data yang diambil meliputi informasi perusahaan dan status registrasi,
     * dengan syarat bahwa ID pj_barantin harus ada dan status registrasi tidak disetujui.
     *
     * @return Builder
     */
    public function queryRegister(): Builder
    {
        return Register::with([
            'barantin.preregister:id,pemohon,jenis_perusahaan',
            'barantin' => function ($query) {
                $query->select('id', 'email', 'nama_perusahaan', 'jenis_identitas', 'nomor_identitas', 'alamat', 'kota', 'provinsi_id', 'negara_id', 'telepon', 'fax', 'status_import', 'user_id', 'pre_register_id');
            }
        ])->select('registers.id', 'master_upt_id', 'pj_barantin_id', 'status', 'keterangan', 'registers.updated_at', 'blockir', 'registers.pre_register_id')->whereNotNull('pj_barantin_id')->whereNot('registers.status', 'DISETUJUI');
    }
    /**
     * Mengkonfirmasi status pendaftaran berdasarkan ID yang diberikan.
     * Memvalidasi status yang diperlukan dan mengupdate register berdasarkan data yang diberikan.
     * Mengembalikan response JSON yang sesuai berdasarkan hasil operasi.
     *
     * @param string $id ID dari register yang akan dikonfirmasi.
     * @param Request $request Data request yang mengandung status dan keterangan.
     * @return JsonResponse
     */
    public function confirmRegister(string $id, Request $request): JsonResponse
    {
        $request->validate(['status' => 'required|in:DISETUJUI,DITOLAK', 'keterangan' => 'nullable']);
        $register = Register::find($id);
        if ($register) {
            $res = $register->update($request->all());
            if ($res) {
                return AjaxResponse::SuccessResponse('data register ' . $request->status, 'permohonan-datatable');
            }
            return AjaxResponse::ErrorResponse('register gagal di aprove', 400);
        }
        return AjaxResponse::ErrorResponse('data register tidak ditemukan', 400);
    }
    /**
     * Menghasilkan JSON response untuk DataTables yang menampilkan dokumen pendukung.
     *
     * @param string $id ID dari baratin atau barantin cabang.
     * @return JsonResponse
     */
    public function datatablePendukung(string $id): JsonResponse
    {
        $model = DokumenPendukung::where('pj_barantin_id', $id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('file', 'register.form.partial.file_pendukung_datatable')
            ->rawColumns(['action', 'file'])
            ->toJson();
    }
}
