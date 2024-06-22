<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    function permissions()
    {
        return $this->belongsTo(Permission::class);
    }
}
