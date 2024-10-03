<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fertiliser extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'code',
        'quantity_per_pack',
        'rate',
        'unit_price',
        'balance',
    ];
}
