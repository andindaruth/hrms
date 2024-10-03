<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'action_id',
        'person_id',
        'quantity_r',
        'date_r',
        'comment',
    ];

    public function equipment_action()
    {
        return $this->belongsTo(EquipmentAction::class);
    }
    public function person()
    {
        return $this->belongsTo(People::class);
    }

}
