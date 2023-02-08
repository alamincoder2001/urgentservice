<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use HasFactory ;

    protected $fillable = [
        "name",
        "username",
        "education",
        "speciality",
        "image",
        "availability",
        "from",
        "to",
        "phone",
        "email",
        "password",
        "city_id",
        "first_fee",
        "second_fee"
    ];

    protected $hidden = [
        'remember_token',
        'password',
    ];

    public function department()
    {
        return $this->hasMany(Specialist::class)->with("specialist");
    }
    public function city()
    {
        return $this->belongsTo(District::class,"city_id", "id");
    }
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, "hospital_id", "id");
    }
    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class, "diagnostic_id", "id");
    }
    public function chamber()
    {
        return $this->hasMany(Chamber::class);
    }

    public function time()
    {
        return $this->hasMany(Sittime::class);
    }
}
