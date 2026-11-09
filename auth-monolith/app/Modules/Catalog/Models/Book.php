<?php

namespace App\Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'slug', 'isbn', 'stock'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'book_category')
                    ->withPivot('added_at');
    }

    // Query Scope: Buku yang stoknya tersedia
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('stock', '>', 0);
    }

    // Query Scope: Pencarian Judul/ISBN
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where('title', 'LIKE', "%{$term}%")
                     ->orWhere('isbn', 'LIKE', "%{$term}%");
    }

    // Query Scope: Filter Kategori
    public function scopeByCategory(Builder $query, int $categoryId): Builder
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }
}