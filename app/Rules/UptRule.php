<?php

namespace App\Rules;

use Closure;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\Validation\ValidationRule;

class UptRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validUpts = collect(BarantinApiHelper::getDataMasterUpt()->original)->pluck('id')->toArray();
        if (!is_array($value)) {
            $value = [$value];
        }

        if (array_diff($value, $validUpts)) {
            $fail('Satu atau lebih upt yang dipilih tidak valid.');
        }
    }
}
