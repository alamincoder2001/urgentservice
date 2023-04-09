<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamberDiagnosticHospital extends Model
{
    use HasFactory;
    
    protected $guarded = ["id"];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, "doctor_id", "id")->with("city");
    }
}
