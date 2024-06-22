<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpEvalDetail extends Model
{
    use SoftDeletes;
    public function EmpEvalMaster()
    {
        return $this->belongsTo(EmpEvalMaster::class,'eval_master_id','id');

    }

    public function evalRate()
    {
        return $this->belongsTo(EvalRate::class,'eval_rate_id','id');

    }
}
