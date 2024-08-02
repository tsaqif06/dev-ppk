<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class UniqueNomorIdentitasNitku implements ValidationRule
{
    protected $nomorIdentitas;
    protected $nitku;

    public function __construct($nomorIdentitas, $nitku)
    {
        $this->nomorIdentitas = $nomorIdentitas;
        $this->nitku = $nitku;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = DB::table('pj_barantins')
            ->where('nomor_identitas', $this->nomorIdentitas)
            ->where('nitku', $this->nitku)
            ->exists();

        if ($exists) {
            $fail('The combination of NPWP and NITKU must be unique.')->translate();
        }
    }
}
