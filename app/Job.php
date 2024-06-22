<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
    public function Employee()
    {
        return $this->hasMany(Employee::class,'job_title','id');

    }
}
