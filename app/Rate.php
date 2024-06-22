<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use SoftDeletes;

    public function evalRate()
    {
        $this->hasMany(EvalRate::class, 'rate_id', 'id');
    }
}
