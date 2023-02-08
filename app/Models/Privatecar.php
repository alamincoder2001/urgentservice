<?php

namespace App\Models;

use Devfaysal\BangladeshGeocode\Models\District;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
