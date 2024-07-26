<?php

namespace App\Rules;

use Closure;
use App\Helpers\BarantinApiHelper;
use Illuminate\Contracts\Validation\ValidationRule;

class KotaRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $provinsiID;
    public function __construct($provinsiID)
    {
        $this->provinsiID = $provinsiID;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validUpts = collect(BarantinApiHelper::getDataMasterKotaByProvinsi($this->provinsiID)->original)->pluck('id')->toArray();
        if (!in_array($value, $validUpts)) {
            $fail('Kota tidak ada.');
        }
    }
}
