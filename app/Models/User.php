<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'users';
    protected $primaryKey = 'UserID';
    protected $fillable = ['Username', 'Fname', 'Lname', 'Email', 'Password'];
    public $timestamps = true;

    // 🔗 Relationships
    public function orders() {
        return $this->hasMany(Order::class, 'UserID', 'UserID');
    }

    public function addresses() {
        return $this->hasMany(Address::class, 'UserID', 'UserID');
    }

    public function cart() {
        return $this->hasOne(Cart::class, 'UserID', 'UserID');
    }

    public function reviews() {
        return $this->hasMany(Review::class, 'UserID', 'UserID');
    }
}
