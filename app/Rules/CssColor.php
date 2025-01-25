<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CssColor implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $colorRegex = '/^'.
            // Hex
            '(#(?:[a-fA-F\d]{3,4}|[a-fA-F\d]{6}|[a-fA-F\d]{8})$)|' .
            // RGB / RGBA
            '(rgba?\(\s*(\d{1,3}%?|100%)\s*(?:,\s*|\s+)(\d{1,3}%?|100%)\s*(?:,\s*|\s+)(\d{1,3}%?|100%)' .
            '(?:\s*(?:,\s*|\s+)(0|1|0?\.\d+))?\s*\)$)|' .
            // HSL / HSLA
            '(hsla?\(\s*(-?\d+deg|-?\d+rad|-?\d+grad|-?\d+turn|\d+)\s*(?:,\s*|\s+)(\d{1,3}%?)\s*(?:,\s*|\s+)(\d{1,3}%?)' .
            '(?:\s*(?:,\s*|\s+)(0|1|0?\.\d+))?\s*\)$)|' .
            // Named values
            '(transparent|inherit|initial|unset)$' .
            '$/i';
    
        if(!preg_match($colorRegex, $value)){
            $fail("The :attribute must be a valid CSS color.");
        }
    }
}
