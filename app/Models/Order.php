<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'OrderID';
    protected $fillable = ['UserID', 'OrderDate', 'TotalPrice', 'PaymentID', 'TrackingID', 'AddressID'];
    public $timestamps = true;

    public function user() {
        return $this->belongsTo(User::class, 'UserID', 'UserID');
    }

    public function payment() {
        return $this->belongsTo(Payment::class, 'PaymentID', 'PaymentID');
    }

    public function tracking() {
        return $this->belongsTo(Tracking::class, 'TrackingID', 'TrackingID');
    }

    public function address() {
        return $this->belongsTo(Address::class, 'AddressID', 'AddressID');
    }

    public function items() {
        return $this->hasMany(OrderItem::class, 'OrderID', 'OrderID');
    }
}
