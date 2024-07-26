<?php

namespace App\Rules;

use Closure;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\Validation\ValidationRule;

class NegaraRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validUpts = collect(BarantinApiHelper::GetDataMasterNegara()->original)->pluck('id')->toArray();
        if (!in_array($value, $validUpts)) {
            $fail('Negara tidak ada.');
        }
    }
}
