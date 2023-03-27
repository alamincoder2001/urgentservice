<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cartype extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function typewiseprivatecar()
    {
        return $this->hasMany(CategoryWisePrivatecar::class)->with("cartype");
    }
}
