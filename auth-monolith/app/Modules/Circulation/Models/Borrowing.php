<?php

namespace App\Modules\Circulation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Modules\Membership\Models\Member;

class Borrowing extends Model
{
    use SoftDeletes;

    protected $fillable = ['member_id', 'borrowed_at', 'due_date', 'returned_at', 'penalty_amount', 'status'];

    // Relasi HasMany ke BorrowingDetail
    public function details(): HasMany
    {
        return $this->hasMany(BorrowingDetail::class, 'borrowing_id');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }
}