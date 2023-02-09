<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialist extends Model
{
    use HasFactory;

    protected $fillable = ["*"];

    public function specialist()
    {
        return $this->belongsTo(Department::class, "department_id", "id");
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class, "doctor_id", "id")->with("city");
    }
    
}
