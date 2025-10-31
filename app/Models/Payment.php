<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'PaymentID';
    protected $fillable = [
        'Status',
        'PayDate',
        'Method',
        'TransactionID',
        'Amount',
        'UserID',
        'CardType',
        'CardLastFour',
        'CardExpMonth',
        'CardExpYear',
    ];

    protected $casts = [
        'Amount' => 'decimal:2',
        'CardExpMonth' => 'integer',
        'CardExpYear' => 'integer',
    ];
    public $timestamps = true;

    public function order() {
        return $this->hasOne(Order::class, 'PaymentID', 'PaymentID');
    }
}
