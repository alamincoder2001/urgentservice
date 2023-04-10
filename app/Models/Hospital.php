<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Hospital extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        "name",
        "username",
        "hospital_type",
        "phone",
        "email",
        "password",
        "map_link",
        "city_id",
        "address",
    ]; 

    protected $hidden = [
        'remember_token',
        'password',
    ];
    
    public function city()
    {
        return $this->belongsTo(District::class, "city_id");
    }

    public function hospital_wise_doctor()
    {
        return $this->hasMany(ChamberDiagnosticHospital::class, 'hospital_id', 'id')->with('doctor');
    }
}
