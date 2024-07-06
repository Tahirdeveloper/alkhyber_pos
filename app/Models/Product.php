<?php

namespace App\Models;
use App\Models\Purchase;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'supplier_id',
        'category',
        'kg',
        'short',
        'netWeight',
        'kgDiscount',
        'description',
        'image',
        'barcode',
        'price',
        'quantity',
        'stock',
        'status',
        'tax',
        'purchase_price',
        'profit',
        'sale_price',
        'grossTotal',
        'purchase_id'
    ];
 protected $table = 'products';   
 protected $primaryKey = 'id';
    public function customer(){
        return $this->belongsTo(Customer::class, 'supplier_id');
    }

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function orders()
    {
        return $this->hasMany(orders::class);
    }
}
