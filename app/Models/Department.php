<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        "name"
    ];

    public function specialistdoctor()
    {
        return $this->hasMany(Specialist::class, "department_id", "id")->with("doctor");
    }
}
