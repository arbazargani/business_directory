<?php

namespace App\Helpers;

class Helper
{
    public static function faNum($input) {
        $enNums = explode(' ', '1 2 3 4 5 6 7 8 9 0');
        $faNums = explode(' ', '۱ ۲ ۳ ۴ ۵ ۶ ۷ ۸ ۹ ۰');
        return str_replace($enNums, $faNums, $input);
    }
}
