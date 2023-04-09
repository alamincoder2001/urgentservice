<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Ambulance extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "name",
        "username",
        "ambulance_type",
        "phone",
        "email",
        "password",
        "city_id",
        "address",
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];
    
    public function city()
    {
        return $this->belongsTo(District::class, "city_id", "id");
    }
    public function upazila()
    {
        return $this->belongsTo(Upazila::class, "upazila_id", "id");
    }

    public static function TotalTypeWiseAmbulance($type)
    {
        return Ambulance::where("ambulance_type", $type)->get()->count();
    }
}
