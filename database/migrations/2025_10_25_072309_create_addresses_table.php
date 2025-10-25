<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id('AddressID');
            $table->string('Province');
            $table->string('District');
            $table->string('Subdistrict');
            $table->string('PostalCode', 10);
            $table->string('AddressLine');
            $table->foreignId('UserID')->constrained('users', 'UserID')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
