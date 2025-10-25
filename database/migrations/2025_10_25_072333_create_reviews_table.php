<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->foreignId('BookID')->constrained('books', 'BookID')->cascadeOnDelete();
            $table->foreignId('UserID')->constrained('users', 'UserID')->cascadeOnDelete();
            $table->tinyInteger('Score')->checkBetween([1,5]);
            $table->text('Comment')->nullable();
            $table->timestamps();
            $table->primary(['BookID', 'UserID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
