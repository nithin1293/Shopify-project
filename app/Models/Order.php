<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'store_id',
        'customer_email',
        'total',
        'status',
    ];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}