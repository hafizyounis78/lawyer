<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpEval extends Model
{
    use SoftDeletes;

    public function Employee()
    {
        return $this->belongsTo(Employee::class,'emp_id','emp_id');

    }
}
