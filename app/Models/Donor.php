<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "phone",
        "dob",
        "email",
        "gender",
        "blood_group",
        "city_id",
        "address",
        "image",
    ];

    public function city()
    {
        return $this->belongsTo(District::class);
    }
}
