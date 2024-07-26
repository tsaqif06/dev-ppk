<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LingkupAktifitasRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $validValues = [1, 2, 3, 4]; // Daftar nilai yang valid
        foreach ($value as $item) {
            if (!in_array($item, $validValues)) {
                $fail('Lingkup aktifitas tidak valid.');
            }
        }
    }
}
