<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'amount',
        'discount',
        'dues',
        'date',
        'paymentMethod',
        'tid',
        'additionalNotes',
        'order_id',
        'customer_id',
        'user_id',
    ];
    protected $nullable = [
       
        'discount',
        'customer_id',
        'tid',
        'additionalNotes',
       
    ];
}
