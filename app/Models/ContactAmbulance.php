<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactAmbulance extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "ambulance_type",
        "phone",
        "departing_date",
        "to",
        "from",
        "trip",
        "ambulance_id"
    ];

    public function ambulance()
    {
        return $this->belongsTo(Ambulance::class, "ambulance_id", "id");
    }
}
