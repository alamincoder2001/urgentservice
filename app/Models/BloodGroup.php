<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    use HasFactory;

    public function donor()
    {
        return $this->hasMany(Donor::class, "blood_group", "id");
    }
}
