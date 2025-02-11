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
        $colorRegex = '/^' .
            // Hex
            '(#(?:[a-fA-F\d]{3,4}|[a-fA-F\d]{6}|[a-fA-F\d]{8})$)|' .
            // RGB / RGBA (0-255 or 0%-100%)
            '(rgba?\(\s*(?:\d{1,2}|1\d{2}|2[0-4]\d|25[0-5]|100%)\s*(?:,\s*|\s+)' .
            '(?:\d{1,2}|1\d{2}|2[0-4]\d|25[0-5]|100%)\s*(?:,\s*|\s+)' .
            '(?:\d{1,2}|1\d{2}|2[0-4]\d|25[0-5]|100%)' .
            '(?:\s*(?:,\s*|\s+)(0|1|0?\.\d+))?\s*\)$)|' .
            // HSL / HSLA (Hue can be any integer, S & L must be 0-100%)
            '(hsla?\(\s*(-?\d+)\s*(?:,\s*|\s+)(100|[1-9]?\d)%\s*(?:,\s*|\s+)(100|[1-9]?\d)%' .
            '(?:\s*(?:,\s*|\s+)(0|1|0?\.\d+))?\s*\)$)|' .
            // Named values
            '(transparent|inherit|initial|unset)$' .
            '$/i';
    
        if(!preg_match($colorRegex, $value)){
            $fail("The :attribute must be a valid CSS color.");
        }
    }
}
