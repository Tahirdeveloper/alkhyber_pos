<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
class Customer extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'role',
        'email',
        'phone',
        'address',
        'avatar',
        'user_id',
    ];

    public function getAvatarUrl()
    {
        return Storage::url($this->avatar);
    }

    public function products()
    {
        return $this->belongsTo(Customer::class);
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
