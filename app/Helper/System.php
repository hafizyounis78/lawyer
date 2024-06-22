<?php

function admin_vw()
{
    return 'admin';
}

function user_vw()
{
    return 'user';
}

function employee_vw()
{
    return 'employee';
}

function externalemp_vw()
{
    return 'externalemp';
}

function admin_company_vw()
{
    return 'admin.company';
}

function admin_lookup_vw()
{
    return 'admin.lookup';
}

function lawsuit_vw()
{
    return 'lawsuit';
}

function procedure_vw()
{
    return 'procedure';
}

function session_vw()
{
    return 'session';
}

function order_vw()
{
    return 'order';
}

function message_vw()
{
    return 'message';
}

function reminder_vw()
{
    return 'reminder';
}

function reports_vw()
{
    return 'reports';
}

function task_vw()
{
    return 'task';
}

function file_vw()
{
    return 'file';
}

function attendance_vw()
{
    return 'attendance';
}

function rating_vw()
{
    return 'rating';
}

function setting_vw()
{
    return 'setting';
}

function role_vw()
{
    return 'role';
}

function getLookupJobs()
{
    /*$translations = Translation::where('trn_type', 'unit')->get();
    $lookups = eloquentToArray($translations, 'trn_foreignKey', 'trn_text', false);
    return $lookups;*/

    $builder = \App\Job::all();
    $lookups = eloquentToArray($builder, 'id', 'desc', false);
    if (isset($lookups))
        return $lookups;
    return null;
}

function getLookupDistricts()
{
    /*$translations = Translation::where('trn_type', 'unit')->get();
    $lookups = eloquentToArray($translations, 'trn_foreignKey', 'trn_text', false);
    return $lookups;*/

    $builder = \App\District::all();
    $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $lookups;
}

function getLookupEmployees()
{
    /*$translations = Translation::where('trn_type', 'unit')->get();
    $lookups = eloquentToArray($translations, 'trn_foreignKey', 'trn_text', false);
    return $lookups;*/

    $builder = \App\Employee::where('org_id', '=', auth()->user()->org_id)->get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupExtEmployees()
{

    $builder = \App\ExternalEmployee::where('org_id', '=', auth()->user()->org_id)->get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupLawsuitSource($id)
{

    $builder = \App\LawsuitSource::where('file_id', '=', $id)->get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupLawyers()
{

    $builder = \App\Employee::where('org_id', '=', auth()->user()->org_id)
        //   ->where('job_title',1)
        ->get();
    //dd($builder);
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupResponsibleLawyers($file_id)
{

    $builder = \App\ResponsibleLawyer::where('file_id', '=', $file_id)->get();
    //dd($builder);
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupCourts()
{

    $builder = \App\Court::get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupFileStatus()
{

    $builder = \App\FileStatus::get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getLookupLawsuitTypes()
{

    $builder = \App\LawsuitType::get();
    //  $lookups = eloquentToArray($builder, 'id', 'desc', false);
    return $builder;
}

function getAgents($id)
{
    $agents = \App\Agent::where('file_id', $id)->get();
    $html = '';
    foreach ($agents as $agent) {
        $html .= '<tr>';
        $html .= '<td>' . $agent->national_id . '</td>';
        $html .= '<td>' . $agent->name . '</td>';
        $html .= '<td>' . $agent->mobile . '</td>';
        $html .= '<td>' . $agent->address . '</td>';
        $html .= '<td>' . $agent->email . '</td>';
        $html .= '<td>' . $agent->justice_national_id . '</td>';
        $html .= '<td>' . $agent->justice_name . '</td>';
        $html .= '<td><button type="button" class="btn btn-icon-only green" onclick="updateAgent(' . $agent->id . ',\'' . $agent->national_id . '\',\'';
        $html .= $agent->name . '\',' . $agent->mobile . ',\'' . $agent->address . '\',\'' . $agent->email . '\',\'' . $agent->justice_national_id . '\',\'' . $agent->justice_name . '\')">';
        $html .= '<i class="fa fa-edit green-haze" ></i > </button >  ';
        $html .= '<button type="button" class="btn btn-icon-only red" onclick="deleteAgent(' . $agent->id . ',this)"><i class="fa fa-minus red" ></i > </button > </td ></tr > ';

    }
    return $html;
}

function getAgentsPrint($id)
{
    $agents = \App\Agent::where('file_id', $id)->get();
    $html = '';
    foreach ($agents as $agent) {
        $html .= '<tr>';
        $html .= '<td>' . $agent->national_id . '</td>';
        $html .= '<td>' . $agent->name . '</td>';
        $html .= '<td>' . $agent->mobile . '</td>';
        $html .= '<td>' . $agent->address . '</td>';
        $html .= '<td>' . $agent->email . '</td>';
        $html .= '<td>' . $agent->justice_national_id . '</td>';
        $html .= '<td>' . $agent->justice_name . '</td></tr > ';

    }
    return $html;
}

function getRespondents($id)
{
    $resps = \App\Respondent::where('file_id', $id)->get();
    $html = '';
    foreach ($resps as $resp) {
        $html .= '<tr>';
        $html .= '<td>' . $resp->national_id . '</td>';
        $html .= '<td>' . $resp->name . '</td>';
        $html .= '<td>' . $resp->mobile . '</td>';
        $html .= '<td>' . $resp->address . '</td>';
        $html .= '<td><button type="button" class="btn btn-icon-only green" onclick="updateResp(' . $resp->id . ',\'' . $resp->national_id . '\',\'' . $resp->name . '\',\'' . $resp->mobile . '\')">';
        $html .= '<i class="fa fa-edit green-haze" ></i > </button >  ';
        $html .= '<button type="button" class="btn btn-icon-only red" onclick="deleteResp(' . $resp->id . ',this)"><i class="fa fa-minus red" ></i > </button > </td ></tr > ';

    }
    return $html;
}

function getRespondentsPrint($id)
{
    $resps = \App\Respondent::where('file_id', $id)->get();
    $html = '';
    foreach ($resps as $resp) {
        $html .= '<tr>';
        $html .= '<td>' . $resp->national_id . '</td>';
        $html .= '<td>' . $resp->name . '</td>';
        $html .= '<td>' . $resp->mobile . '</td>';
        $html .= '<td>' . $resp->address . '</td></tr > ';
    }
    return $html;
}

function getFiles($id)
{
    $resps = \App\LawsuitUploadfile::where('file_id', $id)->get();
    $html = '';
    $i = 0;
    foreach ($resps as $resp) {

        $html .= '<tr><td>' . ++$i . '</td>';
        $html .= '<td><a href="' . url('/public/storage/' . $resp->file_link) . '">' . $resp->file_title . '</a></td>';
        $html .= '<td>' . $resp->created_at->format('d/m/Y') . '</td>';
        $html .= '<td><button onclick="deleteFile(' . $resp->id . ',this)" class="btn red"><i class="fa fa-minus"></i> </button> </td></tr>';
    }
    return $html;
}

function eloquentToArray($models, $keyProp, $valueProp, $nullOption = false)
{
    $arr = array();
    if ($nullOption) {
        $arr[NULL] = '...';
    }
    foreach ($models as $m) {
        $arr[$m->$keyProp] = $m->$valueProp;
    }
    return $arr;
}

