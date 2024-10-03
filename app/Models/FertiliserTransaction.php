<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FertiliserTransaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'vehicle_id',
        'person_id',
        'user_id',
        'fertiliser_id',
        'receipt_number',
        'delivery_note_no',
        'internal_delivery_no',
        'no_of_packs',
        'receipt_no',
        'destination',
        'type',
        'date',
        'is_reversed',
        'reversal_reason',
        'reversed_by',
        'reverses',
    ];

     // Define relationships if necessary
     public function fertiliser()
     {
         return $this->belongsTo(Fertiliser::class);
     }
     public function vehicle()
     {
         return $this->belongsTo(Vehicle::class);
     }
     public function person()
     {
         return $this->belongsTo(People::class);
     }
 
     public function user()
     {
         return $this->belongsTo(User::class);
     }
}
