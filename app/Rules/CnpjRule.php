<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CnpjRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidCnpj($value)) {
            $fail('O :attribute é inválido.');
        }
    }

    private function isValidCnpj(string $cnpj): bool
    {
        // Remove non-digit characters
        $cnpj = preg_replace('/\D/', '', $cnpj);

        // Check if the CNPJ has 14 digits
        if (strlen($cnpj) !== 14) {
            return false;
        }

        // Check if all digits are the same (invalid CNPJ)
        if (preg_match('/^(\d)\1+$/', $cnpj)) {
            return false;
        }

        // Validate the first check digit
        $sum    = 0;
        $weight = 5;

        for ($i = 0; $i < 12; $i++) {
            $sum += intval($cnpj[$i]) * $weight;
            $weight--;

            if ($weight < 2) {
                $weight = 9;
            }
        }
        $mod        = $sum % 11;
        $firstDigit = $mod < 2 ? 0 : 11 - $mod;

        if ($firstDigit != intval($cnpj[12])) {
            return false;
        }

        // Validate the second check digit
        $sum    = 0;
        $weight = 6;

        for ($i = 0; $i < 13; $i++) {
            $sum += intval($cnpj[$i]) * $weight;
            $weight--;

            if ($weight < 2) {
                $weight = 9;
            }
        }
        $mod         = $sum % 11;
        $secondDigit = $mod < 2 ? 0 : 11 - $mod;

        if ($secondDigit != intval($cnpj[13])) {
            return false;
        }

        return true;
    }
}
