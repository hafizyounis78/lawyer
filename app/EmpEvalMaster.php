<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpEvalMaster extends Model
{
    use SoftDeletes;
    protected $appends = ['system_desc', 'eval_result'];

    public function evalDetails()
    {
        return $this->hasMany(EmpEvalDetail::class, 'eval_master_id', 'id');

    }

    public function Employee()
    {
        return $this->belongsTo(Employee::class, 'emp_id', 'emp_id');

    }

    public function EvalSystem()
    {
        return $this->belongsTo(EvalSystem::class, 'eval_system_id', 'id');

    }

    function RateStatus()
    {
        return $this->belongsTo(RateStatus::class, 'eval_status', 'id');
    }

    public function getSystemDescAttribute()
    {
        $name = $this->EvalSystem()->first();
        if (isset($name))
            return $name->desc;
        return '';
    }

    public function getEvalResultAttribute()
    {

        $sum = $this->evalDetails()->sum('value');
        return $sum;
    }

    public function delete()
    {
        // delete all related photos
        $this->evalDetails()->delete();
        // as suggested by Dirk in comment,
        // it's an uglier alternative, but faster
        // Photo::where("user_id", $this->id)->delete()

        // delete the user
        return parent::delete();
    }
}
