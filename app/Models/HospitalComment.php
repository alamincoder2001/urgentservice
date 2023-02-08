<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalComment extends Model
{
    use HasFactory;

    protected $fillable = [
        "hospital_id",
        "contact_id",
        "hospital_comment",
    ];
}
