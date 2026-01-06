<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PalestinianID implements Rule
{
    public function passes($attribute, $value)
    {
        if (!preg_match('/^[0-9]{9}$/', $value)) {
            return false;
        }

        if (substr($value, 0, 3) === "000") {
            return false;
        }

        // التحقق بتقنية Luhn
        return $this->luhnCheck($value);
    }

    public function message()
    {
        return 'رقم الهوية غير صحيح.';
    }

    private function luhnCheck($id)
    {
        $sum = 0;
        $alt = false;

        for ($i = strlen($id) - 1; $i >= 0; $i--) {
            $n = intval($id[$i]);

            if ($alt) {
                $n *= 2;
                if ($n > 9) {
                    $n -= 9;
                }
            }

            $sum += $n;
            $alt = !$alt;
        }

        return ($sum % 10 == 0);
    }
}
