<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryWisePrivatecar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function cartype()
    {
        return $this->belongsTo(Cartype::class, 'cartype_id', "id");
    }
    public function privatecar()
    {
        return $this->belongsTo(Privatecar::class, 'privatecar_id', 'id');
    }
}
