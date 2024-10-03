<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentAction extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'person_id',
        'type',
        'quantity',
        'date',
        'remarks',
        'quantity_r',
        'quantity_p',
        'status',
        'is_reversed',
        'reversal_reason',
        'reversed_by',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function person()
    {
        return $this->belongsTo(People::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // In Transaction model
    public function returns()
    {
        return $this->hasMany(EquipmentReturn::class, 'action_id');
    }

    public function getPendingQuantity()
    {
        return $this->quantity - $this->quantity_r;
    }
}
