<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LubTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'person_id',
        'user_id',
        'lub_id',
        'type',
        'quantity',
        'date',
        'is_reversed',
        'reversal_reason',
        'reversed_by',
    ];

    // Define relationships if necessary
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function person()
    {
        return $this->belongsTo(People::class, 'person_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lub()
    {
        return $this->belongsTo(Lub::class, 'lub_id');
    }
}
