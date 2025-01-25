<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CssDimension implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!preg_match('/^(\d+(\.\d+)?)(%|px|rem|em|vh|vw)?$/', $value)){
            $fail("The :attribute must be a valid CSS dimension.");
        }
    }
}
