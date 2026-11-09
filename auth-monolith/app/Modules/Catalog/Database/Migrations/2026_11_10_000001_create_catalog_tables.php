<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1. Buat tabel categories jika belum ada
        if (!Schema::hasTable('categories')) {
            Schema::create('categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug')->unique();
                $table->foreignId('parent_id')->nullable()->constrained('categories')->onDelete('cascade');
                $table->timestamps();
            });
        }

        // 2. Buat tabel books jika belum ada
        if (!Schema::hasTable('books')) {
            Schema::create('books', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('isbn')->unique();
                $table->integer('stock')->default(0);
                $table->softDeletes();
                $table->timestamps();
            });
        }

        // 3. Buat tabel pivot book_category jika belum ada
        if (!Schema::hasTable('book_category')) {
            Schema::create('book_category', function (Blueprint $table) {
                $table->id();
                $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
                $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
                $table->timestamp('added_at')->useCurrent();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('book_category');
        Schema::dropIfExists('books');
        Schema::dropIfExists('categories');
    }
};