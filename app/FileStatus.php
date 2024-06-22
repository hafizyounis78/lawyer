<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FileStatus extends Model
{
    use SoftDeletes;
    function lawsuit()
    {
        return  $this->hasMany(Lawsuit::class,'file_status');
    }
}
