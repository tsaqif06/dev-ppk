<?php

namespace App\Http\Requests;

use App\Rules\UptRule;
use App\Rules\KotaRule;
use App\Rules\ProvinsiRule;
use Illuminate\Validation\Rule;
use App\Rules\NomerIdentitasRule;
use App\Rules\LingkupAktifitasRule;
use App\Rules\UniquePerusahaanInduk;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestPerusahaanStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'upt' => [
                'required',
                new UptRule
            ],
            'jenis_identitas' => ['required', Rule::in(['NPWP'])],
            'nama_perusahaan' => 'required',
            'identifikasi_perusahaan' => 'nullable|in:cabang,induk',
            'nomor_identitas' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas')),

            ],
            'telepon' => 'required',
            'fax' => 'required|regex:/^\(\d{3}\) \d{3}-\d{4}$/',

            'email' => 'required|exists:pre_registers,email',
            'lingkup_aktivitas' => [
                'required',
                new LingkupAktifitasRule
            ],
            'nama_alias_perusahaan' => Rule::requiredIf(function () {
                $lingkup_aktivitas = request()->input('lingkup_aktivitas');
                return $lingkup_aktivitas && in_array(3, $lingkup_aktivitas);
            }),
            'nitku' => 'required_if:identifikasi_perusahaan,cabang',
            'status_import' => ['required', Rule::in([25, 26, 27, 28, 29, 30, 31, 32])],
            // 'negara' => 'required|exists:master_negaras,id',
            'kota' => ['required', new KotaRule(request()->input('provinsi'))],
            'provinsi' => ['required', new ProvinsiRule],
            'alamat' => 'required',

            'nama_cp' => 'required',
            'alamat_cp' => 'required',
            'telepon_cp' => 'required',

            'nama_tdd' => 'required',
            'jenis_identitas_tdd' => ['required', Rule::in(['KTP', 'NPWP', 'PASSPORT'])],
            'nomor_identitas_tdd' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas_tdd'))
            ],
            'jabatan_tdd' => 'required',
            'alamat_tdd' => 'required',
            'jenis_perusahaan' => 'required|in:PEMILIK BARANG,PPJK,EMKL,EMKU,LAINNYA',
            'ketentuan' => 'required|in:ketentuan',

            'rerata_frekuensi' => 'required',
            'daftar_komoditas' => 'required',
            'status_kepemilikan' => 'required',
        ];
    }
}
