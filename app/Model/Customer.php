<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customer';
    protected $fillable = [
        'id', 'uuid','page_id','type','created_at','count_message','id_tags','updated_at'
    ];
}
