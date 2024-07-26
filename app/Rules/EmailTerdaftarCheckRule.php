<?php

namespace App\Rules;

use Closure;
use App\Models\Register;
use App\Models\PreRegister;
use Illuminate\Contracts\Validation\ValidationRule;

class EmailTerdaftarCheckRule implements ValidationRule
{

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $preregister = PreRegister::with('register:id,master_upt_id,pre_register_id')->where('email', $value)->first();
        if ($preregister) {
            $this->checkRegisters($preregister, $fail);
        }
    }

    private function checkRegisters($preregister, Closure $fail)
    {
        foreach ($preregister->register as $register) {
            $this->checkUptStatus($register, $fail);
        }
    }

    private function checkUptStatus($register, Closure $fail)
    {
        foreach (request()->input('upt') as $upt) {
            if (in_array($upt, $register->pluck('master_upt_id')->all())) {
                $this->validateRegisterStatus($register->id, $upt, $fail);
            }
        }
    }

    private function validateRegisterStatus($registerId, $upt, Closure $fail)
    {
        $register = Register::where('id', $registerId)->where('master_upt_id', $upt)->first();
        if (isset($register->status)) {
            if ($register->status === 'MENUNGGU') {
                $fail('email sudah terdaftar di upt yang dipilih status menunggu');
            }
            if ($register->status === 'DISETUJUI') {
                $fail('email sudah terdaftar di upt yang dipilih status disetujui');
            }
        }
    }
}
