<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EvalRate extends Model
{
    protected $appends = ['rate_desc','rate_value'];

    use SoftDeletes;

    public function Rates()
    {
        return $this->belongsTo(Rate::class,'rate_id','id');

    }
    public function getRateDescAttribute()
    {

        $rate_desc = $this->Rates()->first();
        if (isset($rate_desc))
            return $rate_desc->desc;
        return '';

    }
    public function getRateValueAttribute()
    {

        $rate_desc = $this->Rates()->first();
        if (isset($rate_desc))
            return $rate_desc->value;
        return 0;
    }
    public function EmpEvalDetail()
    {
        return $this->hasMany(EmpEvalDetail::class,'eval_rate_id','id');

    }
}
