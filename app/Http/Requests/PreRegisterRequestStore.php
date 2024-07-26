<?php

namespace App\Http\Requests;

use App\Rules\UptRule;
use App\Models\Register;
use App\Models\MasterUpt;
use App\Models\PreRegister;
use App\Models\PjBaratanKpp;
use Illuminate\Validation\Rule;
use App\Helpers\BarantinApiHelper;
use App\Rules\EmailTerdaftarCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class PreRegisterRequestStore extends FormRequest
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
            'pemohon' => ['required', Rule::in(['perorangan', 'perusahaan'])],
            'jenis_perusahaan' => [
                Rule::requiredIf(fn() => request()->input('pemohon') == 'perusahaan'),
                Rule::excludeIf(fn() => request()->input('pemohon') == 'perorangan'),
                Rule::in(['INDUK', 'CABANG']),
            ],
            'nama' => 'required|max:255',
            'email' => [
                'required',
                'email',
                'max:50',
              new EmailTerdaftarCheckRule,
            ]
        ];
    }
}
