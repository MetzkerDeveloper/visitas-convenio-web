<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->isValidPhone($value)) {
            $fail('O telefone informado é inválido. O formato deve ser: (DDD) XXXX-XXXX ou (DDD) XXXXX-XXXX. Somente números, sem pontos ou traços.');
        }
    }

    private function isValidPhone(string $phone): bool
    {
        // Remove non-digit characters and whitespace
        $phone = preg_replace('/\D/', '', $phone);

        //regex test
        $regex = '/^[1-9]{2}(?:[2-8]|9[0-9])[0-9]{7,8}$/';

        return preg_match($regex, $phone);

    }
}
