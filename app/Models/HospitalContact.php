<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalContact extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "message",
        "subject",
        "phone",
        "hospital_id",
    ];

    public function feedback()
    {
        return $this->hasMany(HospitalComment::class, "contact_id", "id");
    }
}
 