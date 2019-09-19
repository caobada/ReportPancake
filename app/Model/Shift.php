<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    //
    public $timestamps = false;
    protected $table = 'shift';
    protected $fillable = [
        'id', 'name_shift', 'timestart','timeend'
    ];
}
