<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('OrderID');
            $table->foreignId('UserID')->constrained('users', 'UserID')->cascadeOnDelete();
            $table->dateTime('OrderDate')->default(now());
            $table->decimal('TotalPrice', 10, 2);
            $table->foreignId('PaymentID')->nullable()->constrained('payments', 'PaymentID')->nullOnDelete();
            $table->foreignId('TrackingID')->nullable()->constrained('trackings', 'TrackingID')->nullOnDelete();
            $table->foreignId('AddressID')->constrained('addresses', 'AddressID')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
