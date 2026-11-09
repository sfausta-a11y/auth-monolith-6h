<?php

namespace App\Modules\Catalog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'parent_id'];

    // Relasi ke Kategori Induk
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relasi Self-referencing ke Sub-kategori
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relasi Many-to-Many dengan Pivot added_at
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'book_category')
                    ->withPivot('added_at');
    }
}