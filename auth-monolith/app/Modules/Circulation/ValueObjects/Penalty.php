<?php

namespace App\Modules\Circulation\ValueObjects;

use Carbon\Carbon;

class Penalty
{
    private const DAILY_RATE = 2000; // Rp 2.000 per hari keterlambatan

    public static function calculate(string $dueDate, string $returnDate): float
    {
        $due = Carbon::parse($dueDate);
        $returned = Carbon::parse($returnDate);

        if ($returned->gt($due)) {
            $lateDays = $returned->diffInDays($due);
            return (float) ($lateDays * self::DAILY_RATE);
        }

        return 0.0;
    }
}