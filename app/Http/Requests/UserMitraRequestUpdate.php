<?php

namespace App\Http\Requests;

use App\Rules\KotaRule;
use App\Rules\NegaraRule;
use App\Rules\ProvinsiRule;
use Illuminate\Validation\Rule;
use App\Rules\NomerIdentitasRule;
use Illuminate\Foundation\Http\FormRequest;

class UserMitraRequestUpdate extends FormRequest
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
            'nama_mitra' => 'required|string|max:255',
            'jenis_identitas_mitra' => ['required', Rule::in(['KTP', 'NPWP', 'PASSPORT'])],
            'nomor_identitas_mitra' => [
                'required',
                'numeric',
                new NomerIdentitasRule(request()->input('jenis_identitas_mitra'))
            ],

            'alamat_mitra' => 'required|string|max:255',
            'telepon_mitra' => 'required|string|max:255',
            'negara' => ['required', new NegaraRule],
            'provinsi' => ['required_if:negara,99', new ProvinsiRule],
            'kabupaten_kota' => ['required_if:negara,99', new KotaRule(request()->input('provinsi'))],
        ];
    }
}
