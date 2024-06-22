<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reminder extends Model
{
    protected $appends = ['emp_name', 'reminder_desc', 'file_color', 'file_desc', 'file_no'];
    use SoftDeletes;

    function Lawsuit()
    {
        return $this->belongsTo(Lawsuit::class, 'file_id', 'id');
    }

    function employee()
    {
        return $this->belongsTo(Employee::class, 'lawyer_id', 'emp_id');
    }

    function reminderType()
    {
        return $this->belongsTo(ReminderType::class, 'reminder_type', 'id');
    }

    public function getEmpNameAttribute()
    {
        $emp = $this->employee()->first();
        if (isset($emp))
            return $emp->name;
        return '';
    }

    public function getReminderDescAttribute()
    {
        $type = $this->reminderType()->first();
        if(isset($type))
            return $type->desc;
        return '';
    }

    public function LawsuitType()
    {
        return $this->belongsTo(LawsuitType::class, 'lawsuit_type', 'id');

    }

    public function getFileColorAttribute()
    {
        $type = $this->LawsuitType()->first();
        if (isset($type))
            return $type->file_color;
        return '';
    }

    public function getFileDescAttribute()
    {
        $type = $this->LawsuitType()->first();
        if (isset($type))
            return $type->desc;
        return '';
    }

    public function getFileNoAttribute()
    {
        $lawsuit = $this->Lawsuit()->first();
        if (isset($lawsuit))
            return $lawsuit->file_no;
        return '';
    }
}
