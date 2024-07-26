<?php

namespace App\Rules;

use Closure;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\Validation\ValidationRule;

class ProvinsiRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validUpts = collect(BarantinApiHelper::getDataMasterProvinsi()->original)->pluck('id')->toArray();
        if (!in_array($value, $validUpts)) {
            $fail('Provinsi tidak ada.');
        }
    }
}
