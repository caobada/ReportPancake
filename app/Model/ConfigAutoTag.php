<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ConfigAutoTag extends Model
{
    //
    public $timestamps = false;
    protected $table = 'config_auto_tag';
    protected $fillable = [
        'position','token','page_id'
    ];
}
