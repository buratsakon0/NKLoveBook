<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'reviews';
    protected $fillable = ['BookID', 'UserID', 'Score', 'Comment'];
    public $timestamps = true;

    public function book() {
        return $this->belongsTo(Book::class, 'BookID', 'BookID');
    }

    public function user() {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }
}
