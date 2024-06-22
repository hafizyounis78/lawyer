<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lawsuit extends Model
{
    use SoftDeletes;

    protected $primaryKey = "id";
    protected $appends = ['agent_name', 'respondent_name', 'court_name', 'lawyers_name',
        'procedure_date', 'last_procedure_date', 'session_date', 'one_session_date', 'future_session_date', 'session_text', 'one_session_text',
        'type_desc', 'file_color', 'file_status_desc', 'lawsuit_result_desc', 'file_location_desc', 'procedure_text','last_procedure_text'];

    function lawsuitType()
    {
        return $this->belongsTo(LawsuitType::class, 'lawsuit_type', 'id');
    }

    function fileStatus()
    {
        return $this->belongsTo(FileStatus::class, 'file_status', 'id');
    }

    function lawsuitResult()
    {
        return $this->belongsTo(LawsuitResult::class, 'lawsuit_result', 'id');
    }

    function fileLocation()
    {
        return $this->belongsTo(FileLocation::class, 'file_location', 'id');
    }

    function Courts()
    {
        return $this->belongsTo(Court::class, 'court_id', 'id');
    }

    function Agents()
    {
        return $this->hasMany(Agent::class, 'file_id', 'id');
    }

    function Respondents()
    {
        return $this->hasMany(Respondent::class, 'file_id', 'id');
    }

    function Procedure()
    {
        return $this->hasMany(Procedure::class, 'file_id', 'id');
    }

    function Session()
    {
        return $this->hasMany(Session::class, 'file_id', 'id');
    }

    public function getProcedureDateAttribute()
    {
        $model = $this->Procedure()->orderBy('created_at')->pluck('prcd_date')
            ->toArray();
        //  dd( $model[0]);
        for ($i = 0; $i < count($model); ++$i) {
            $exp = explode(' ', $model[$i]);
            $model[$i] = $exp[0];
        }

        return implode(" || \n", $model);
    }

    public function getLastProcedureDateAttribute()
    {
        $model = $this->Procedure()->max('prcd_date');
        //dd($model);
        if (isset($model))
            return $model;
        return '';
    }

    public function getProcedureTextAttribute()
    {
        $model = $this->Procedure()->orderBy('created_at')->pluck('prcd_text')
            ->toArray();
        //  dd( $model[0]);
        return implode(" || <br/>", $model);
    }
    public function getLastProcedureTextAttribute()
    {
        $model = $this->Procedure()->orderBy('prcd_date','desc')->first();
        //dd($model);
        if (isset($model->prcd_text))
            return $model->prcd_text;
        return '';
    }
    public function getSessionDateAttribute()
    {
        $model = $this->Session()->orderBy('created_at')->pluck('session_date')
            ->toArray();
        //  dd( $model[0]);
        for ($i = 0; $i < count($model); ++$i) {
            $exp = explode(' ', $model[$i]);
            $model[$i] = $exp[0];
        }

        return implode(" || \n", $model);
    }

    public function getSessionTextAttribute()
    {
        $model = $this->Session()->orderBy('created_at')->pluck('session_text')
            ->toArray();


        return implode(" || <br/>", $model);
    }

    public function getOneSessionTextAttribute()
    {
        $model = $this->Session()->whereDate('session_date', '=', Carbon::today())->first();


        if (isset($model))
            return $model->session_text;
        return '';
    }

    public function getOneSessionDateAttribute()
    {
        $model = $this->Session()->whereDate('session_date', '=', Carbon::today())->first();


        if (isset($model))
            return $model->session_date;
        return '';
    }

    public function getFutureSessionDateAttribute()
    {
        $model = $this->Session()->whereDate('session_date', '>=', Carbon::today())->first();


        if (isset($model))
            return $model->session_date;
        return '';
    }

    public function getAgentNameAttribute()
    {
        $agents = $this->Agents()->pluck('name')->toArray();

        return implode(",", $agents);
    }

    public function getLawyersNameAttribute()
    {
        $lawyers = $this->LawsuitLawyers()->pluck('lawyer_id')->toArray();
        $names = '';
        $dash = '';
        foreach ($lawyers as $lawyer) {
            $emp = Employee::where('emp_id', '=', $lawyer)->first();
            if (isset($emp)) {
                $names = $names . $dash . $emp->name;
                $dash = '-';
            }
        }
        if (isset($lawyers))
            return $names;
        return '';
    }

    public function getRespondentNameAttribute()
    {
        $agents = $this->Respondents()->pluck('name')->toArray();

        return implode(",", $agents);
    }

    public function getCourtNameAttribute()
    {
        $court = $this->Courts()->first();
        if (isset($court))
            return $court->desc;
        return '';
    }

    public function getFileStatusDescAttribute()
    {
        $tb = $this->fileStatus()->first();
        if (isset($tb))
            return $tb->desc;
        return '';
    }

    public function getFileLocationDescAttribute()
    {
        $tb = $this->fileLocation()->first();
        if (isset($tb))
            return $tb->desc;
        return '';
    }

    public function getLawsuitResultDescAttribute()
    {
        $tb = $this->lawsuitResult()->first();
        if (isset($tb))
            return $tb->desc;
        return '';
    }

    public function LawsuitLawyers()
    {
        return $this->hasMany(ResponsibleLawyer::class, 'file_id', 'id');
    }

    public function getTypeDescAttribute()
    {
        $type = $this->lawsuitType()->first();
        if (isset($type))
            return $type->desc;
        return '';
    }

    public function getFileColorAttribute()
    {
        $type = $this->LawsuitType()->first();
        if (isset($type))
            return $type->file_color;
        return '';
    }

}
