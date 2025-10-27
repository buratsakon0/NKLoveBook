<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $table = 'wishlists'; // ระบุชื่อ table ที่ใช้ใน database

    public $timestamps = true; // ถ้าคุณไม่ได้ใช้ created_at, updated_at ให้เปลี่ยนเป็น false

    // ตั้งค่า Relationship กับ User และ Book
    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'BookID');
    }
}
