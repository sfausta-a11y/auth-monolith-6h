<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->date('borrowed_at');
            $table->date('due_date');
            $table->date('returned_at')->nullable();
            $table->decimal('penalty_amount', 10, 2)->default(0);
            $table->enum('status', ['borrowed', 'returned', 'late'])->default('borrowed');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('borrowing_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')->constrained('borrowings')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books');
            $table->integer('qty')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_details');
        Schema::dropIfExists('borrowings');
    }
};