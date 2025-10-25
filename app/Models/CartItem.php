<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $fillable = ['CartID', 'BookID', 'Quantity'];
    public $timestamps = false;

    public function cart() {
        return $this->belongsTo(Cart::class, 'CartID', 'CartID');
    }

    public function book() {
        return $this->belongsTo(Book::class, 'BookID', 'BookID');
    }
}
