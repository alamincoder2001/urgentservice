<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investigation extends Model
{
    use HasFactory;
    protected $fillable = ["*"];

    public function investigationDetails()
    {
        return $this->hasMany(InvestigationDetails::class, "investigation_id", "id");
    }
}
