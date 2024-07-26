<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NomerIdentitasRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    private $jenisIdentitas;
    public function __construct($jenisIdentitas)
    {
        $this->jenisIdentitas = $jenisIdentitas;
    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->jenisIdentitas === 'KTP' || $this->jenisIdentitas === 'NPWP') {
            if (!preg_match('/^[0-9]{16}$/', $value)) {
                $fail('Nomor dokumen harus berupa 16 digit.');
            }
        }

    }
}
