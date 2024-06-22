<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    protected $appends = ['emp_name', 'status_name'];

    function taskStatus()
    {
        return $this->belongsTo(TaskStatus::class, 'task_status', 'id');
    }

    function Employee()
    {
        return $this->belongsTo(Employee::class, 'lawyer_id', 'emp_id');
    }

    public function getEmpNameAttribute()
    {
        $agents = $this->Employee()->pluck('name')->toArray();
        if (isset($agents))
            return implode(",", $agents);
        return '';
    }

    public function getStatusNameAttribute()
    {
        $rec = $this->taskStatus()->first();
        if (isset($rec))
            return $rec->desc;
        return '';
    }
}
