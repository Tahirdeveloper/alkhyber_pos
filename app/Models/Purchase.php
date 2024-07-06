<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable=[
        'invoice_number','purchaseDate', 'discount', 'allTotal', 'paidAmount', 'purchase_note', 'dues', 'payment_method', 'acc_no', 'payment_note','product_id','supplier_id'
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
