<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chemical extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'category',
        'purpose',
        'unit_of_measure',
        'quantity_per_pack',
        'rate',
        'unit_price',
        'balance',
    ];

    
}
