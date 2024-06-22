<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResponsibleLawyer extends Model
{
    use SoftDeletes;
    protected $primaryKey = "id";
    protected $appends = ['lawyer_name', 'lawyer_mobile'];

    function employee()
    {
        return $this->belongsTo(Employee::class, 'lawyer_id', 'emp_id');
    }

    public function getLawyerNameAttribute()
    {
        $name = $this->employee()->pluck('name');
        if (isset($name))
            return $name;
        return '';
    }

    public function getLawyerMobileAttribute()
    {
        $mobile = $this->employee()->pluck('mobile');
        if (isset($mobile))
            return $mobile;
        return '';
    }

    public function LawyerLawsuit()
    {
        return $this->belongsTo(Lawsuit::class, 'file_id', 'id');
    }
}
