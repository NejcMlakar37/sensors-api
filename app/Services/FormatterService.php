<?php

namespace App\Services;

class FormatterService
{
    /**
     * @param float $value
     * @return string
     */
    public static function formatFloat(float $value): string
    {
        return number_format($value, 2, '.', ' ');
    }
}
