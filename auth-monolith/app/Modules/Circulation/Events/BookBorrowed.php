<?php

namespace App\Modules\Circulation\Events;

use App\Modules\Circulation\Models\Borrowing;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookBorrowed
{
    use Dispatchable, SerializesModels;

    public Borrowing $borrowing;

    public function __construct(Borrowing $borrowing)
    {
        $this->borrowing = $borrowing;
    }
}