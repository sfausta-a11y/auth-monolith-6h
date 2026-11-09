<?php

namespace App\Modules\Circulation\Listeners;

use App\Modules\Circulation\Events\BookBorrowed;
use Illuminate\Support\Facades\Log;

class SendBorrowNotification
{
    public function handle(BookBorrowed $event): void
    {
        Log::info("Domain Event: Peminjaman Berhasil. Borrowing ID: {$event->borrowing->id}, Member ID: {$event->borrowing->member_id}");
    }
}