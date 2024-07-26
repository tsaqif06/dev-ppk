<?php

namespace App\Http\Requests;

use App\Rules\KotaRule;
use App\Rules\ProvinsiRule;
use Illuminate\Validation\Rule;
use App\Rules\NomerIdentitasRule;
use Illuminate\Foundation\Http\FormRequest;

class UserPppjkRequestStore extends FormRequest
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
            'nama_ppjk' => 'required|string|max:255',
            'email_ppjk' => 'required|email|max:255',
            'tanggal_kerjasama_ppjk' => 'required|date',
            'alamat_ppjk' => 'required|string|max:255',

            'jenis_identitas_ppjk' => ['required', Rule::in(['KTP', 'NPWP', 'PASSPORT'])],
            'nomor_identitas_ppjk' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas_ppjk'))
            ],

            'provinsi' => ['required', new ProvinsiRule],
            'kabupaten_kota' => ['required', new KotaRule(request()->input('provinsi'))],

            'nama_cp_ppjk' => 'required|string|max:255',
            'alamat_cp_ppjk' => 'required|string|max:255',
            'telepon_cp_ppjk' => 'required|regex:/^\d{4}-\d{4}-\d{4}$/',

            'nama_tdd_ppjk' => 'required|string|max:255',

            'jenis_identitas_tdd_ppjk' => ['required', Rule::in(['KTP', 'NPWP', 'PASSPORT'])],
            'nomor_identitas_tdd_ppjk' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas_tdd_ppjk'))
            ],

            'jabatan_tdd_ppjk' => 'required|string|max:255',
            'alamat_tdd_ppjk' => 'required|string|max:255',
            'status_ppjk' => 'required|in:AKTIF,NONAKTIF',
        ];
    }
}
