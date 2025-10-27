<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    // ตั้งชื่อ table ให้ตรงกับในฐานข้อมูล
    protected $table = 'wishlists';

    // กำหนดความสัมพันธ์กับ User และ Book
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'BookID');
    }
}
