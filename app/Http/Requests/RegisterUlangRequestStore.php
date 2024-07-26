<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterUlangRequestStore extends FormRequest
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
            'email' => 'required|exists:pj_baratan_kpps,email|unique:pre_registers,email',
            'username' => 'required|exists:pj_baratan_kpps,kode_perusahaan'
        ];
    }
    public function messages(): array
    {
        return [
            'email.unique' => 'email sudah di register ulang di upt yang dipilih'
        ];
    }
}
