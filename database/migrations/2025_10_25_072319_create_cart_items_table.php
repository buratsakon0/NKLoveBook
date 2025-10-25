<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->foreignId('CartID')->constrained('carts', 'CartID')->cascadeOnDelete();
            $table->foreignId('BookID')->constrained('books', 'BookID')->cascadeOnDelete();
            $table->integer('Quantity')->default(1);
            $table->primary(['CartID', 'BookID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
