<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait GenerateCode
{
    public static function generateUniqueCode($prefix = '', $column = "code")
    {
        $code = $prefix.Str::random(16 - strlen($prefix));

        while (self::where($column, $code)->exists()) {
            $code = $prefix.Str::random(16 - strlen($prefix));
        }

        return $code;
    }

    public static function generateUniqueNumericCode(string $prefix, $codeLength = 16, $column = "code")
    {
        $remainingLength = $codeLength - strlen($prefix);
        $code            = $prefix.mt_rand(0, str_pad(10, $remainingLength, '0') - 1);

        while (self::where($column, $code)->exists()) {
            $code = $prefix.mt_rand(0, str_pad(10, $remainingLength, '0') - 1);
        }

        return $code;
    }
}
