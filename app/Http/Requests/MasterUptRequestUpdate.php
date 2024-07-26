<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MasterUptRequestUpdate extends FormRequest
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
            'kode_satpel' => 'required|max:5',
            'kode_upt' => 'required|max:5',
            'nama' => 'required|max:255',
            'nama_en' => 'nullable|max:255',
            'wilayah_kerja' => 'required|max:50',
            'nama_satpel' => 'required|max:50',
            'kota' => 'required|max:50',
            'kode_pelabuhan' => 'nullable|max:45',
            'tembusan' => 'nullable|max:255',
            'otoritas_pelabuhan' => 'nullable|max:255',
            'syah_bandar_pelabuhan' => 'nullable|max:255',
            'kepala_kantor_bea_cukai' => 'nullable|max:255',
            'nama_pengelola' => 'nullable|max:255',
            'stat_ppkol' => ['nullable', Rule::in('Y', 'N')],
            'stat_insw' => ['nullable', Rule::in('Y', 'N')],
        ];
    }
}
