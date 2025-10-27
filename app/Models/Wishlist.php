<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $primaryKey = 'WishListID';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'UserID',
        'BookID',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'BookID', 'BookID')
            ->withDefault();
    }
}
