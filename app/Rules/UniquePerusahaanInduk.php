<?php

namespace App\Rules;

use Closure;
use App\Models\PjBarantin;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePerusahaanInduk implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $identitas;
    protected $update = false;
    public function __construct(string $identias, bool $update = false)
    {
        $this->identitas = $identias;
        $this->update = $update;

    }
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->identitas == 'induk') {
            $nomer = PjBarantin::whereRelation('preregister', 'jenis_perusahaan', 'induk')->where('nomor_identitas', $value)->first();
            if ($nomer) {
                if ($this->update && $nomer->nomor_identitas != $value) {
                    $fail("Nomor identitas sudah ada")->translate();
                }
                if (!$this->update) {
                    $fail("Nomor identitas sudah ada")->translate();
                }
            }
        }
    }
}
