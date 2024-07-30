<?php

namespace App\Http\Controllers\Register;

use App\Models\Register;
use App\Models\PjBarantin;
use App\Models\PreRegister;
use App\Models\PjBaratanKpp;
use Illuminate\Http\Request;
use App\Helpers\AjaxResponse;
use App\Models\DokumenPendukung;
use App\Helpers\JsonFilterHelper;
use Illuminate\Http\JsonResponse;
use App\Helpers\BarantinApiHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection as Collect;
use App\Http\Requests\DokumenPendukungRequestStore;
use App\Http\Requests\RegisterRequesPerorangantStore;
use App\Http\Requests\RegisterRequestPerusahaanStore;


class RegisterController extends Controller
{

    /**
     * Menampilkan indeks formulir registrasi berdasarkan ID pra-registrasi.
     *
     * @param string $id ID dari pra-registrasi yang ingin ditampilkan formulirnya.
     * @return View Mengembalikan tampilan formulir registrasi.
     */
    public function RegisterFormulirIndex(string $id): View
    {
        $register = PreRegister::find($id);
        $this->CheckRegister($register);
        $baratan = PjBaratanKpp::where('email', $register->email)->value('id');
        if ($baratan) {
            return view('register.form.index', compact('id', 'baratan'));
        }
        return view('register.form.index', compact('id'));
    }
    /**
     * Menangani permintaan formulir registrasi melalui AJAX.
     *
     * @param Request $request Data permintaan dari pengguna.
     * @param string $id ID dari pra-registrasi.
     * @return View Mengembalikan tampilan yang sesuai berdasarkan jenis pemohon.
     */
    public function RegisterForm(Request $request, string $id): View
    {
        $register = PreRegister::find($id);
        $this->CheckRegister($register);
        $baratan = PjBaratanKpp::find($request->baratan_id) ?? null;

        $view = 'register.form.partial.perorangan';
        if ($register->pemohon === 'perusahaan') {
            $view = 'register.form.partial.perusahaan';
        }
        return view($view, compact('register', 'baratan'));
    }
    /**
     * Menyimpan data registrasi perorangan.
     * Fungsi ini akan memeriksa keberadaan dokumen KTP atau PASSPORT sebelum melanjutkan proses registrasi.
     * Jika dokumen lengkap, data akan diproses dan disimpan.
     * Jika tidak, akan dikembalikan respons dengan pesan kesalahan.
     *
     * @param RegisterRequesPerorangantStore $request Data request yang diterima
     * @param string $id ID pra-registrasi
     * @return \Illuminate\Http\JsonResponse
     */
    public function StoreRegisterPerorangan(RegisterRequesPerorangantStore $request, string $id)
    {
        $preRegister = PreRegister::find($id);
        $this->CheckRegister($preRegister);
        $dokumen = DokumenPendukung::where('pre_register_id', $id)->pluck('jenis_dokumen');

        if ($dokumen->contains('KTP') || $dokumen->contains('PASSPORT')) {
            $data = self::inputRender($request, $preRegister->id);
            self::saveBarantin($request->upt, $data);
            return response()->json(['status' => true, 'message' => 'Register Perorangan Berhasil Dilakukan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen KTP/PASSPORT'], 422);
    }
    /**
     * Menangani proses registrasi untuk perusahaan induk.
     * Fungsi ini akan memeriksa keberadaan dokumen NPWP dan NIB sebelum melanjutkan proses registrasi.
     * Jika dokumen lengkap, data akan diproses dan disimpan.
     * Jika tidak, akan dikembalikan respons dengan pesan kesalahan.
     *
     * @param RegisterRequestPerusahaanStore $request Data request yang diterima
     * @param string $id ID pra-registrasi
     * @return \Illuminate\Http\JsonResponse
     */
    public function StoreRegisterPerusahaan(RegisterRequestPerusahaanStore $request, string $id)
    {
        // var_dump($request->input());
        // die;
        $preRegister = PreRegister::find($id);
        $this->CheckRegister($preRegister);
        $dokumen = DokumenPendukung::where('pre_register_id', $id)->pluck('jenis_dokumen');

        if ($request->identifikasi_perusahaan == 'induk') {
            return self::isPerusahaanInduk($dokumen, $request, $preRegister->id);
        }
        return self::isPerusahaanCabang($dokumen, $request, $preRegister->id);
    }

    public static function isPerusahaanInduk(Collect $dokumen, Request $request, string $preRegisterId): JsonResponse
    {
        if ($dokumen->contains('NPWP') && $dokumen->contains('NIB')) {
            $data = self::inputRender($request, $preRegisterId);
            self::saveBarantin($request->upt, $data);
            return response()->json(['status' => true, 'message' => 'Register Perusahaan induk Berhasil Dilakukan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen NPWP, NIB'], 422);
    }

    public static function isPerusahaanCabang(Collect $dokumen, Request $request, string $preRegisterId): JsonResponse
    {
        if ($dokumen->contains('NITKU')) {
            $data = self::inputRender($request, $preRegisterId);
            self::saveBarantin($request->upt, $data);
            return response()->json(['status' => true, 'message' => 'Register Perusahaan cabang Berhasil Dilakukan'], 200);
        }
        return response()->json(['status' => false, 'message' => 'silahkan lengkapi dokumen NITKU'], 422);
    }

    /**
     * Menyimpan data registrasi perusahaan induk perorangan menggunakan transaksi database.
     * Fungsi ini bertanggung jawab untuk membuat entri baru untuk Pjbarantin dan memperbarui data pra-registrasi.
     * Selain itu, fungsi ini juga mengelola status registrasi UPT berdasarkan kondisi yang ada.
     *
     * @param array $uptp untuk upt yang
     * @param array $data Data yang akan disimpan
     */
    public static function saveBarantin(array $upt, array $data): void
    {
        $data['tindakan_karantina'] = $data['tindakan_karantina'] == 'Ya';
        DB::transaction(
            function () use ($data, $upt) {
                $barantin = PjBarantin::create($data);
                PreRegister::find($data['pre_register_id'])->update(['nama' => $barantin->nama_perusahaan]);
                foreach ($upt as $index => $value) {
                    Register::updateOrCreate(
                        ['pre_register_id' => $data['pre_register_id'], 'master_upt_id' => $value],
                        ['pj_barantin_id' => $barantin->id, 'status' => 'MENUNGGU', 'keterangan' => null]
                    );
                }
                DokumenPendukung::where('pre_register_id', $data['pre_register_id'])
                    ->update(['pj_barantin_id' => $barantin->id, 'pre_register_id' => null]);
            }
        );
    }

    public static function inputRender(Request $request, string $preRegisterId): array
    {
        $request->merge([
            'negara_id' => 99,
            'nitku' => $request->nitku ?? '000000',
            'nama_alias_perusahaan' => $request->nama_alias_perusahaan,
            'provinsi_id' => $request->provinsi,
            'pre_register_id' => $preRegisterId,
            'lingkup_aktifitas' => implode(',', $request->lingkup_aktivitas),
        ]);

        return $request->except(['upt', 'negara', 'provinsi', 'identifikasi_perusahaan', 'lingkup_aktivitas', 'ketentuan']);
    }

    /**
     * Menyimpan dokumen pendukung ke dalam database.
     *
     * Fungsi ini akan menyimpan file dokumen yang diunggah ke dalam penyimpanan publik
     * dan mencatat detail dokumen tersebut ke dalam database.
     *
     * @param string $id ID dari pra-registrasi
     * @param DokumenPendukungRequestStore $request Data request yang mengandung informasi dokumen
     * @return JsonResponse Respon JSON yang mengindikasikan hasil operasi
     */
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

    /**
     * Mengelola data tabel untuk dokumen pendukung.
     *
     * Fungsi ini mengambil data dokumen pendukung berdasarkan ID pra-registrasi
     * dan mengembalikan data tersebut dalam format JSON untuk digunakan dalam DataTables.
     *
     * @param string $id ID dari pra-registrasi
     * @return JsonResponse Respon JSON yang mengandung data dokumen pendukung
     */
    public function DokumenPendukungDataTable(string $id): JsonResponse
    {
        $model = DokumenPendukung::where('pre_register_id', $id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('action', 'register.form.partial.action_pendukung_datatable')
            ->editColumn('file', 'register.form.partial.file_pendukung_datatable')
            ->rawColumns(['action', 'file'])
            ->toJson();
    }
    /**
     * Menghapus dokumen pendukung dari database dan penyimpanan.
     *
     * Fungsi ini akan menghapus file dokumen pendukung dari penyimpanan publik
     * dan menghapus entri dokumen dari database. Jika operasi berhasil,
     * akan mengembalikan respon sukses, jika gagal akan mengembalikan respon error.
     *
     * @param string $id ID dokumen pendukung yang akan dihapus
     * @return JsonResponse Respon JSON yang mengindikasikan hasil operasi
     */
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
    /**
     * Memeriksa status registrasi dan validasi email.
     * Fungsi ini akan menghentikan proses jika email belum terverifikasi atau registrasi masih dalam proses.
     *
     * @param mixed $preRegister Data registrasi yang akan diperiksa.
     * @return RedirectResponse|bool Mengembalikan true jika pemeriksaan berhasil, atau mengarahkan kembali jika terdapat masalah.
     */
    public function CheckRegister(mixed $preRegister): RedirectResponse|bool
    {
        if (!$preRegister || !$preRegister->verify_email) {
            abort(redirect()->route('register.message')->with(['message_token' => 'Email tidak terverifikasi silahkan register ulang']));
        }
        /* ambil dat terbaru untuk pengecekan bahwa status sudah fix */
        $register = Register::where('pre_register_id', $preRegister->id)->orderBy('updated_at', 'DESC')->first();

        if (isset($register)) {
            if ($register->status == 'MENUNGGU' || $register->status == 'DISETUJUI') {
                abort(redirect()->route('register.message')->with(['message_waiting' => 'Data sedang di proses upt yang dipilih atau yang terdaftar sebelumnya']));
            }
        }

        return true;
    }
    /**
     * Menangani permintaan untuk mendapatkan status registrasi.
     * Fungsi ini mengembalikan respons JSON jika permintaan dilakukan melalui AJAX,
     * dan mengembalikan tampilan halaman status jika tidak.
     *
     * @return View|JsonResponse
     */
    public function StatusRegister() //: View|JsonResponse
    {
        if (request()->ajax()) {
            $model = Register::with([
                'preregister:nama,id,pemohon,jenis_perusahaan',
                'barantin:nama_perusahaan,id,nama_tdd,jabatan_tdd,jenis_perusahaan,kota,provinsi_id'
            ])
                ->select('registers.id', 'master_upt_id', 'pj_barantin_id', 'status', 'keterangan', 'pre_register_id', 'updated_at')
                ->whereNotNull('pj_barantin_id')
                ->whereNotNull('status')
                ->orderBy('created_at', 'DESC');
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
                ->addColumn('kota', function ($row) {
                    $kota = BarantinApiHelper::getMasterKotaByIDProvinsiID($row->barantin->kota, $row->barantin->provinsi_id);
                    return $kota['nama'] ?? null;
                })
                ->filterColumn('kota', function ($query, $keyword) {
                    $kota = collect(BarantinApiHelper::getDataMasterKota()->original);
                    $idKota = JsonFilterHelper::searchDataByKeyword($kota, $keyword, 'nama')->pluck('id');
                    $query->whereHas('barantin', fn ($query) => $query->whereIn('kota', $idKota));
                })
                ->addIndexColumn()->toJson();
        }
        return view('register.status.index');
    }

    /**
     * Menampilkan halaman pesan untuk proses registrasi.
     * Fungsi ini mengembalikan view yang berisi pesan-pesan terkait proses registrasi.
     *
     * @return View Mengembalikan view pesan registrasi.
     */

    public function RegisterMessage(): View
    {
        return view('register.message');
    }
}
