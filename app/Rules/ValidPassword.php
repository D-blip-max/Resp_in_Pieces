<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidPassword implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        // Mínimo 8 caracteres
        if (strlen($value) < 8) {
            return false;
        }

        // Al menos 1 número
        if (!preg_match('/\d/', $value)) {
            return false;
        }

        // Al menos 1 mayúscula
        if (!preg_match('/[A-Z]/', $value)) {
            return false;
        }

        // Al menos 1 minúscula
        if (!preg_match('/[a-z]/', $value)) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'La contraseña debe incluir al menos 1 número, 1 mayúscula y 1 minúscula.';
    }
}
