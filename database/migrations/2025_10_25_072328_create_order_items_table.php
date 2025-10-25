<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->foreignId('OrderID')->constrained('orders', 'OrderID')->cascadeOnDelete();
            $table->foreignId('BookID')->constrained('books', 'BookID')->cascadeOnDelete();
            $table->integer('Quantity')->default(1);
            $table->decimal('UnitPrice', 8, 2);
            $table->primary(['OrderID', 'BookID']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
