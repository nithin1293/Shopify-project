<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    protected $fillable = [
        'product_details',
        'customer_name',
        'total',
        'status',
        'user_id',
        
    ];

    protected $casts = [
    'product_details' => 'array',
    ];


    // ... (existing relationships) ...

    // ADD THIS RELATIONSHIP
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ADD THIS RELATIONSHIP (Optional)
    // Assumes you add 'order_id' to the 'payments' table
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
