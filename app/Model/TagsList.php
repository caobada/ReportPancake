<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TagsList extends Model
{
    //
    protected $table = 'tags_list';
    protected $fillable = [
        'id', 'name_tag','type', 'id_tag','created_at'
    ];
}
