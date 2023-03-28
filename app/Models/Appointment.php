<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        "appointment_date",
        "doctor_id",
        "name",
        "age",
        "district",
        "upozila",
        "contact"
    ];

    public function city()
    {
        return $this->belongsTo(District::class, "district");
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class, "upozila");
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, "doctor_id");
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }
    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
    public function chamber()
    {
        return $this->belongsTo(Chamber::class);
    }
}
