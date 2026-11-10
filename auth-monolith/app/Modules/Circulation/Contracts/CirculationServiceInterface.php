<?php

namespace App\Modules\Circulation\Contracts;

use App\Modules\Circulation\Models\Borrowing;

interface CirculationServiceInterface
{
    public function borrowBooks(int $memberId, array $bookIds, int $days = 7): Borrowing;
}