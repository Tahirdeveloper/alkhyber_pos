<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'order_id',
        'user_id'
    ];
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getCustomerName()
    {
        if($this->customer) {
            return $this->customer->first_name . ' ' . $this->customer->last_name;
        }
        return 'Walkin Customer';
    }
    public function getCustomerAddress()
    {
        if($this->customer) {
            return $this->customer->address;
        }
        return 'Unknown';
    }
    public function getCustomerId()
    {
        if($this->customer) {
            return $this->customer->id;
        }
        return 0;
    }

    public function total()
    {
        return $this->payments->map(function ($i){
            return $i->amount+ $i->discount;
        })->sum();
    }

    public function formattedTotal()
    {
        return number_format($this->total(), 2);
    }

    public function receivedAmount()
    {
        return $this->payments->map(function ($i){
            return $i->amount;
        })->sum();
    }
    
    public function gross_total()
    {
        return $this->payments->map(function ($i){
            return (($i->amount)+($i->discount)+($i->dues));
        });
    }
    public function dueDate()
    {
        return $this->payments->map(function ($i){
            return $i->date;
        });
    }
    public function formattedReceivedAmount()
    {
        return number_format($this->receivedAmount(), 2);
    }
}
