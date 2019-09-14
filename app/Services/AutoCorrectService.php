<?php

namespace App\Services;

class AutoCorrectService
{
    public static function autoSpace(string $str): string
    {
        $str = preg_replace('/([\x{4e00}-\x{9fa5}]+)([A-Za-z0-9_]+)/u', '${1} ${2}', $str);
        $str = preg_replace('/([A-Za-z0-9_]+)([\x{4e00}-\x{9fa5}]+)/u', '${1} ${2}', $str);

        return $str;
    }
}
