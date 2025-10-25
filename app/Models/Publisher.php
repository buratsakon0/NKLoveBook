<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    use HasFactory;

    protected $table = 'publishers';
    protected $primaryKey = 'PublisherID';
    protected $fillable = ['PublisherName'];
    public $timestamps = true;

    public function books() {
        return $this->hasMany(Book::class, 'PublisherID', 'PublisherID');
    }
}
