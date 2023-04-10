<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Diagnostic extends Authenticatable
{
    use HasFactory;
    
    protected $fillable = [
        "name",
        "username",
        "diagnostic_type",
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

    public function diagnostic_wise_doctor()
    {
        return $this->hasMany(ChamberDiagnosticHospital::class, 'diagnostic_id', 'id')->with('doctor');
    }
}
