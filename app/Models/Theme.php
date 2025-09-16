<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $fillable = ['name', 'settings'];

    protected $casts = [
        'settings' => 'array', 
    ];
}