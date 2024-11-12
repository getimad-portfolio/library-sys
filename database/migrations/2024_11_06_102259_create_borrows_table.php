<?php

use App\Enums\BorrowStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrows', function (Blueprint $table) {
            $table->id();
            $table->timestamp('borrowed_at')->nullable();
            $table->timestamp('due_date')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->string('status')->default(BorrowStatus::BORROWED->value);
            $table->timestamps();

            $table->foreignId('member_id')->constrained('members')->onDelete('cascade');
            $table->foreignId('book_id')->constrained('books')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrows');
    }
};
