<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // ชื่อตารางจริงใน DB
    protected $table = 'categories';

    // ชื่อ primary key จริง
    protected $primaryKey = 'CategoryID';

    // ให้ Laravel รู้ว่าคอลัมน์ที่ใช้บ่อยคืออะไร
    protected $fillable = ['CategoryName'];

    public $timestamps = true;
}
