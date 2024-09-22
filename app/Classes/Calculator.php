<?php

namespace App\Classes;

class Calculator
{
    private array $table;

    public function __construct()
    {
        $experience = 0;
        $table = [];

        for ($level = 1; $level <= 151; $level++) {
            $table[$level] = floor($experience / 4);
            $experience += ($level + (300 * pow(2, $level / 7)));
        }

        $this->table = $table;
    }

    public function experience(int $level): float
    {
        $level = max(1, min($level, 150));

        return $this->table[$level];
    }

    public function level(float $experience): int
    {
        for ($level = 2; $level <= 151; $level++) {
            if ($this->table[$level] > $experience) {
                return $level - 1;
            }
        }

        return 150;
    }

    public function progress(float $experience): float
    {
        $level = $this->level($experience);
        if ($level === 150) {
            return 0;
        }

        $base = $this->experience($level);
        $next = $this->experience($level + 1);

        return (($experience - $base) * 100) / ($next - $base);
    }
}
