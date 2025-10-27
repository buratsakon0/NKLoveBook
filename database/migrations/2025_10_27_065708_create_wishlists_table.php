<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWishlistsTable extends Migration
{
    public function up()
    {
        Schema::create('wishlists', function (Blueprint $table) {
            $table->bigIncrements('WishListID');  // เปลี่ยนจาก $table->id() เป็น $table->bigIncrements('WishListID')
            $table->foreignId('UserID')->constrained('users', 'UserID')->onDelete('cascade');
            $table->foreignId('BookID')->constrained('books', 'BookID')->onDelete('cascade');
            $table->timestamps();

            // สร้าง unique constraint ที่คอมบิเนชั่นของ UserID กับ BookID
            $table->unique(['UserID', 'BookID']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('wishlists');
    }
}

