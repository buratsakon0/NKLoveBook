<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $primaryKey = 'BookID';
     protected $fillable = [
        'BookName', 'ISBN', 'Price', 'Pages', 'Description',
        'CategoryID', 'PublisherID', 'AuthorID', 'cover_image'
    ];

    public $timestamps = true;

    public function category() {
        return $this->belongsTo(Category::class, 'CategoryID', 'CategoryID');
    }

    public function author() {
        return $this->belongsTo(Author::class, 'AuthorID', 'AuthorID');
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class, 'PublisherID', 'PublisherID');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'BookID', 'BookID');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'BookID');
    }
}
