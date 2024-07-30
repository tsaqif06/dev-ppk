<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class Helper
{
    public static function generateRandomPassword($length = 6): string
    {
        return Str::random($length);
    }

    public static function generateRandomString($length = 7): string
    {
        return Str::random($length);
    }
}
