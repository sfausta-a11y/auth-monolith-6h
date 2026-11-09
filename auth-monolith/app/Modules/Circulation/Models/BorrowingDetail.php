<?php

namespace App\Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Model;
use App\Modules\Catalog\Models\Book;

class BorrowingDetail extends Model
{
    protected $fillable = ['borrowing_id', 'book_id', 'qty'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}