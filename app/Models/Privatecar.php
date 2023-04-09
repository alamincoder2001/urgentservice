<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Devfaysal\BangladeshGeocode\Models\Upazila;
use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Privatecar extends Authenticatable
{
    use HasFactory; 

    protected $guarded = ["id"];
    
    protected $hidden = [
        'remember_token',
        'password',
    ];

    public function city()
    {
        return $this->belongsTo(District::class);
    }

    public function upazila()
    {
        return $this->belongsTo(Upazila::class, "upazila_id", "id");
    }

    public function typewisecategory()
    {
        return $this->hasMany(CategoryWisePrivatecar::class, "privatecar_id", "id")->with('cartype');
    }
}
