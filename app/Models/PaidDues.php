<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaidDues extends Model
{
    use HasFactory;
    protected $fillable =[
        'paid_amount',
        'note',
        'purchase_id',
    ];
}
