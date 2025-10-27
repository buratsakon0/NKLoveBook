<?php

class Wishlist extends Model
{
    protected $primaryKey = 'WishListID';  // ใช้ 'WishListID' แทน 'id'
    protected $fillable = ['UserID', 'BookID'];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }

    public function book()
    {
        return $this->belongsTo(Book::class, 'BookID');
    }
}


