<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiagnosticComment extends Model
{
    use HasFactory;

    protected $fillable = [
        "diagnostic_id",
        "contact_id",
        "diagnostic_comment",
    ];
}
