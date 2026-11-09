<?php

namespace App\Modules\Circulation\Services;

use App\Modules\Catalog\Models\Book;
use App\Modules\Circulation\Models\Borrowing;
use App\Modules\Circulation\Models\BorrowingDetail;
use App\Modules\Circulation\Events\BookBorrowed;
use Illuminate\Support\Facades\DB;
use Exception;

class CirculationService
{
    public function borrowBooks(int $memberId, array $bookIds, int $days = 7): Borrowing
    {
        return DB::transaction(function () use ($memberId, $bookIds, $days) {
            // 1. Catat Peminjaman Utama
            $borrowing = Borrowing::create([
                'member_id'   => $memberId,
                'borrowed_at' => now(),
                'due_date'    => now()->addDays($days),
                'status'      => 'borrowed',
            ]);

            foreach ($bookIds as $bookId) {
                // Lock data buku
                $book = Book::where('id', $bookId)->lockForUpdate()->first();

                // 2. Transaksi otomatis ROLLBACK jika stok habis
                if (!$book || $book->stock < 1) {
                    throw new Exception("Stok buku '{$book->title}' habis. Transaksi dibatalkan.");
                }

                // Kurangi stok
                $book->decrement('stock');

                // Simpan Rincian Detail
                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'book_id'     => $book->id,
                    'qty'         => 1,
                ]);
            }

            // 3. Trigger Domain Event setelah transaksi sukses
            event(new BookBorrowed($borrowing));

            return $borrowing;
        });
    }
}