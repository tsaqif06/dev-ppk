<?php

namespace App\Http\Requests;

use App\Models\DokumenPendukung;
use App\Models\PreRegister;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DokumenPendukungRequestStore extends FormRequest
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
            'jenis_dokumen' => [
                'required',
                Rule::in('KTP', 'PASSPORT', 'NPWP', 'SIUP', 'surat_keterangan_domisili', 'NIB', 'TDP', 'angka_pengenal_importir', 'NITKU'),
                function ($attribute, $value, $fail) {
                    if (in_array($value, ['KTP', 'PASSPORT', 'NPWP', 'SIUP', 'surat_keterangan_domisili', 'NIB', 'NITKU'])) {
                        $id = request()->route('id');
                        $dokumen = DokumenPendukung::where('jenis_dokumen', $value)->where('pre_register_id', $id)->first();
                        if ($dokumen) {
                            $fail('Anda hanya dapat memiliki satu jenis dokumen.');
                        }
                    }
                },
            ],
            'nomer_dokumen' => [
                'required',
                'numeric',
                function ($attr, $val, $fail) {
                    $jenis_dokumen = request()->input('jenis_dokumen');

                    if ($jenis_dokumen === 'KTP' || $jenis_dokumen === 'NPWP') {
                        if (!preg_match('/^[0-9]{16}$/', $val)) {
                            $fail('Nomor dokumen harus berupa 16 digit.');
                        }
                    }
                    if ($jenis_dokumen === 'NITKU') {
                        if (!preg_match('/^[0-9]{6}$/', $val)) {
                            $fail('Nomor dokumen harus berupa 6 digit.');
                        }
                    }

                }
            ],
            'tanggal_terbit' => 'required|date',
            'file_dokumen' => 'required|file|mimes:pdf|max:2000'
        ];
    }
}
