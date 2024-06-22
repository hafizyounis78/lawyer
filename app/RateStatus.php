<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateStatus extends Model
{
    function EmpEvalMasters()
    {
        return $this->hasMany(EmpEvalMaster::class, 'eval_status', 'id');
    }
}
