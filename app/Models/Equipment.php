<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image',
        'category1',
        'category2',
        'category3',
        'quantity_in_stock',
        're_order_value',
    ];
}
