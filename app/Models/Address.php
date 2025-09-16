<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'mobile_number',
        'street',
        'landmark',
        'town',
        'state',
        'country',
        'pincode',
        'flat_no',
        'address_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}