<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use SoftDeletes;

    public function Lawsuit()
    {
        return $this->belongsTo(Lawsuit::class,'file_id','id');

    }

}
