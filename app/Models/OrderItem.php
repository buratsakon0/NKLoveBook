<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';
    protected $fillable = ['OrderID', 'BookID', 'Quantity', 'UnitPrice'];
    public $timestamps = false;

    public function order() {
        return $this->belongsTo(Order::class, 'OrderID', 'OrderID');
    }

    public function book() {
        return $this->belongsTo(Book::class, 'BookID', 'BookID');
    }
}
