<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agent extends Model
{
    use SoftDeletes;
    function lawsuit()
    {
        return  $this->belongsTo(Lawsuit::class,'file_id','id');
    }
}
