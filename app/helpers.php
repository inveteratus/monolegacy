<?php

use App\Classes\Calculator;

if (!function_exists('level')) {
    function level(float $experience)
    {
        return app(Calculator::class)->level($experience);
    }
}

if (!function_exists('progress')) {
    function progress(float $experience)
    {
        return app(Calculator::class)->progress($experience);
    }
}

if (!function_exists('atm')) {
    function atm(int $amount): array
    {
        $result = [];
        $value = 100;
        while ($value <= $amount) {
            $result[] = $value;
            $value *= str_starts_with((string)$value, '1') ? 5 : 2;
            if (count($result) > 5) {
                array_shift($result);
            }
        }
        return $result;
    }
}
