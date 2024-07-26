<?php

namespace App\Rules;

use Closure;
use App\Models\Register;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\Validation\ValidationRule;

class UptUserCheckRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $idBarantin;

    public function __construct($idBarantin)
    {
        $this->idBarantin = $idBarantin;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $register = Register::where(function ($query) {
            $query->where('pj_barantin_id', $this->idBarantin)->orWhere('barantin_cabang_id', $this->idBarantin);
        })->select(['master_upt_id', 'id', 'status'])->get(); // Gunakan select() di sini

        foreach ($value as $upt) {
            if (in_array($upt, $register->pluck('master_upt_id')->toArray())) {
                $foundRegister = $register->firstWhere('master_upt_id', $upt);
                if ($foundRegister && in_array($foundRegister->status, ['MENUNGGU', 'DISETUJUI'])) {
                    $upt = BarantinApiHelper::getMasterUptByID($upt);
                    $fail("UPT  {$upt['nama']} memiliki status " . strtolower($foundRegister->status));
                }
            }
        }

    }
}
