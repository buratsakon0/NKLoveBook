<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'trackings';
    protected $primaryKey = 'TrackingID';
    protected $fillable = ['Status'];
    public $timestamps = true;

    public function order() {
        return $this->hasOne(Order::class, 'TrackingID', 'TrackingID');
    }
}
