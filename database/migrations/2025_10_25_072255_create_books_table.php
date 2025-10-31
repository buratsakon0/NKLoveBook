<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id('BookID');
            $table->string('BookName');
            $table->string('ISBN')->unique();
            $table->decimal('Price', 8, 2)->index();
            $table->integer('Pages');
            $table->text('Description')->nullable();
            $table->foreignId('CategoryID')->constrained('categories', 'CategoryID')->cascadeOnDelete();
            $table->foreignId('PublisherID')->constrained('publishers', 'PublisherID')->cascadeOnDelete();
            $table->foreignId('AuthorID')->constrained('authors', 'AuthorID')->cascadeOnDelete();
            $table->string('cover_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
