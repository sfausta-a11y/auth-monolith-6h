<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Modules\Catalog\Models\Category;
use App\Modules\Catalog\Models\Book;
use App\Modules\Membership\Models\Member;

class LibrarySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Kategori (Menggunakan firstOrCreate agar aman jika dijalankan berulang)
        $tech = Category::firstOrCreate(
            ['slug' => 'teknologi'],
            ['name' => 'Teknologi']
        );

        $programming = Category::firstOrCreate(
            ['slug' => 'pemrograman'],
            [
                'name' => 'Pemrograman', 
                'parent_id' => $tech->id
            ]
        );

        // 2. Data Buku (Stok 5 & Stok 0 untuk pengujian rollback)
        $book1 = Book::firstOrCreate(
            ['isbn' => '978-602-000-1'],
            [
                'title' => 'Arsitektur Modular Monolith',
                'slug'  => 'arsitektur-modular-monolith',
                'stock' => 5,
            ]
        );

        $book2 = Book::firstOrCreate(
            ['isbn' => '978-602-000-2'],
            [
                'title' => 'DDD Practice in PHP',
                'slug'  => 'ddd-practice-in-php',
                'stock' => 0,
            ]
        );

        // Relasi Pivot
        if (!$book1->categories()->where('category_id', $programming->id)->exists()) {
            $book1->categories()->attach($programming->id);
        }
        if (!$book2->categories()->where('category_id', $programming->id)->exists()) {
            $book2->categories()->attach($programming->id);
        }

        // 3. Data Member
        Member::firstOrCreate(
            ['member_code' => 'MBR-001'],
            ['name' => 'Salma', 'status' => 'active']
        );
        
        Member::firstOrCreate(
            ['member_code' => 'MBR-002'],
            ['name' => 'Fausta', 'status' => 'active']
        );
    }
}