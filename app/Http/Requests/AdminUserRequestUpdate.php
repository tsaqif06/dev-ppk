<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequestUpdate extends FormRequest
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
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $this->route('admin_user'),
            'username' => 'required|string|max:255|unique:admins,username,' . request()->route('admin_user'),
            'password' => 'nullable|string|min:8',
            'upt' => 'required|exists:master_upts,id|unique:admins,upt_id,' . request()->route('admin_user'),
        ];
    }
}
