<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticContact extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "email",
        "phone",
        "subject",
        "message",
        "diagnostic_id",
    ];

    public function feedback()
    {
        return $this->hasMany(DiagnosticComment::class, "contact_id", "id");
    }
}
