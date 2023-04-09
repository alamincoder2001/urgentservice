<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DayTime extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public static function daygroup($type_id, $day)
    {
        return DayTime::where(['type_id'=> $type_id, 'day'=> $day])->get();
    }
}
