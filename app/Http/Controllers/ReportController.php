<?php

namespace App\Http\Controllers;

use App\EmpEvalMaster;
use App\Employee;
use App\EvalSystem;
use App\Lawsuit;
use App\LawsuitSource;
use App\RateStatus;
use App\ResponsibleLawyer;
use App\Task;
use App\TaskStatus;
use App\LawsuitResult;
use Illuminate\Http\Request;
use PDF;
use App;

class ReportController extends Controller
{
    //
    public function lawsuit_report()
    {
        $this->data['sub_menu'] = 'report';
        $this->data['location_title'] = 'التقارير';
        $this->data['location_link'] = 'lawsuit-report';
        $this->data['title'] = 'التقارير';
        $this->data['page_title'] = 'تقرير ملفات الدعوى';
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['externalEmps'] = getLookupExtEmployees();
        $this->data['courts'] = getLookupCourts();
        $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
        $this->data['fileStatus'] = getLookupFileStatus();
        $this->data['lawsuitResults'] = LawsuitResult::get();

        return view(reports_vw() . '.rep1')->with($this->data);
    }

    public function attend_report()
    {
        $this->data['sub_menu'] = 'report';
        $this->data['location_title'] = 'التقارير';
        $this->data['location_link'] = 'attendance-report';
        $this->data['title'] = 'التقارير';
        $this->data['page_title'] = 'تقرير حركات الموظفين';
        $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
        return view(reports_vw() . '.rep2')->with($this->data);
    }

    public function task_report()
    {
        $this->data['sub_menu'] = 'report';
        $this->data['location_title'] = 'التقارير';
        $this->data['location_link'] = 'task-report';
        $this->data['title'] = 'التقارير';
        $this->data['page_title'] = 'تقرير المهام';
        $this->data['task_statuses'] = TaskStatus::all();
        $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
        return view(reports_vw() . '.rep3')->with($this->data);
    }

    public function rate_report()
    {
        $this->data['sub_menu'] = 'report';
        $this->data['location_title'] = 'التقارير';
        $this->data['location_link'] = 'rate-report';
        $this->data['title'] = 'التقارير';
        $this->data['page_title'] = 'تقرير تقييم الموظفين';
        $this->data['evalSystems'] = EvalSystem::all();
        $this->data['rateStatuses'] = RateStatus::all();
        $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
        return view(reports_vw() . '.rep4')->with($this->data);
    }

    public function lawsuitReport(Request $request)
    {
        $name = $request->name;
        $file_no = $request->file_no;
        $open_date = $request->open_date;
        $lawsuit_type = $request->lawsuit_type;
        $suit_type = $request->suit_type;
        $court_id = $request->court_id;
        $judge = $request->judge;
        $lawyers = $request->lawyers;
        $lawsources = $request->lawsources;
        $police_file_no = $request->police_file_no;
        $file_status = $request->file_status;
        $agent_national_id = $request->agent_national_id;
        $lawsuit_result = $request->lawsuit_result;
        $prosecution_file_no = $request->prosecution_file_no;

        if (isset($agent_national_id) && $agent_national_id != null) {
            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents'])
                ->whereHas('agents', function ($q) use ($agent_national_id) {
                    $q->where('agents.national_id', '=', $agent_national_id);
                });

        } else
            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents']);


        /*if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {

            if (isset($agent_national_id) && $agent_national_id != null) {
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents'])
                    ->whereHas('agents', function ($q) use ($agent_national_id) {
                        $q->where('agents.national_id', '=', $agent_national_id);
                    });

            } else
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents']);

        } else {

            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();

            if (isset($agent_national_id) && $agent_national_id != null) {
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents' => function ($q) use ($agent_national_id) {
                    $q->where('agents.national_id', '=', $agent_national_id);
                }])
                    ->whereIn('id', $files);
            } else {

                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents'])->whereIn('id', $files);
            }

        }*/
        if (isset($name) && $name != null && $name != '') {

            $agent_list = App\Agent::where('name', 'like', '%' . $name . '%')->pluck('file_id')->toArray();
            //  dd($agent_list);
            // $sql = "lawyer_id  in ";
            $lawsuit = $lawsuit->whereIn('id', $agent_list);
        }
        if (isset($file_no) && $file_no != null) {
            $lawsuit = $lawsuit->where('file_no', $file_no);

        }
        if (isset($open_date) && $open_date != null) {
            $lawsuit = $lawsuit->whereDate('open_date', '=', $open_date);
        }
        if (isset($lawsuit_type) && $lawsuit_type != null && $lawsuit_type != 0) {
            $lawsuit = $lawsuit->where('lawsuit_type', $lawsuit_type);
        }

        if (isset($suit_type) && $suit_type != null) {
            $lawsuit = $lawsuit->where('suit_type', $suit_type);
        }
        if (isset($prosecution_file_no) && $prosecution_file_no != null) {
            $lawsuit = $lawsuit->where('prosecution_file_no', $prosecution_file_no);
        }
        if (isset($court_id) && $court_id != null) {
            $lawsuit = $lawsuit->where('court_id', $court_id);
        }
        if (isset($judge) && $judge != null) {
            $lawsuit = $lawsuit->where('judge', $judge);
        }
        if (isset($lawsuit_result) && $lawsuit_result != 0) {
            $lawsuit = $lawsuit->where('lawsuit_result', $lawsuit_result);
        }
        if (isset($lawyers) && $lawyers != null && $lawyers != 0) {
            // $lawsuit= $lawsuit->WhereIn('judge',$judge);
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyers)->pluck('file_id')->toArray();
            $lawsuit = $lawsuit->whereIn('id', $files);
        }
        if (isset($lawsources) && $lawsources != null && $lawsources != 0) {
            $files = LawsuitSource::where('lawyer_id', '=', $lawsources)->pluck('file_id')->toArray();

            $lawsuit = $lawsuit->whereIn('id', $files);

        }
        if (isset($police_file_no) && $police_file_no != null) {
            $lawsuit = $lawsuit->where('police_file_no', $police_file_no);
        }
        /* if (isset($file_status) && $file_status != null && $file_status != 0) {

             $lawsuit = $lawsuit->where('file_status', $file_status);
         }*/
        if (isset($file_status)  && $file_status == 0) {

            $lawsuit = $lawsuit->where('file_status','!=', 4);
        }
        // $lawsuit = $lawsuit->whereNull('deleted_at');
        $lawsuits = $lawsuit->orderBy('court_id');
        $num = 1;
        return datatables()->of($lawsuit)
            ->addColumn('delChk', function ($item) {
                return '<label class="mt-checkbox mt-checkbox-single mt-checkbox-outline"> <input type="checkbox" data-id= "' . $item->id . '" id="' . $item->id . '" class="checkboxes" value="1" /><span></span></label>';
            })
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })->addColumn('court_name', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->court_name))
                    return $lawsuit->court_name;
                return '';
            })
            ->addColumn('agent_name', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->agent_name))
                    return $lawsuit->agent_name;
                return '';
            })
            ->addColumn('respondent_name', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->respondent_name))
                    return $lawsuit->respondent_name;
                return '';
            })
            ->addColumn('lawsuitColor', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->lawsuitType->desc)) {
                    //  return '<span style="background-color:' . $lawsuit->lawsuitType->file_color . '">' . $lawsuit->lawsuitType->desc . '</span>';
                    $fontBlack = '';
                    if ($lawsuit->lawsuitType->file_color == '#fafffd'||$lawsuit->lawsuitType->file_color == '#ffffff'||$lawsuit->lawsuitType->file_color == '#f7fffe')
                        $fontBlack = ';color: black';
                    return '<span class="badge" style="background-color:' . $lawsuit->lawsuitType->file_color . $fontBlack . '">' . $lawsuit->lawsuitType->desc . '</span>';
                }
                return '';
            })
            ->addColumn('procedure_date', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->procedure_date))
                    return $lawsuit->procedure_date;
                return '';
            })
            ->addColumn('session_date', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->session_date))
                    return $lawsuit->session_date;
                return '';
            })
            ->addColumn('session_text', function ($lawsuit) {// as foreach ($users as $user)

                if (isset($lawsuit->procedure_text))
                    return $lawsuit->procedure_text;
                return '';
            })
            ->addColumn('lawsuitvalues', function ($lawsuit) {// as foreach ($users as $user)
                $curr = [0 => ' ', 1 => 'NIS', 2 => 'US', 3 => 'JOD'];
                $html = '';
                if (isset($lawsuit->lawsuit_value) && $lawsuit->lawsuit_value != 0)
                    $html = $lawsuit->lawsuit_value . ' ' . $curr[$lawsuit->currency] . '  <br>  ';
                if (isset($lawsuit->lawsuit_value2) && $lawsuit->lawsuit_value2 != 0)
                    $html .= $lawsuit->lawsuit_value2 . ' ' . $curr[$lawsuit->currency2];
                return $html;
            })
            ->addColumn('file_status_desc', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->fileStatus->desc))
                    return $lawsuit->fileStatus->desc;
                return '';
            })
            ->addColumn('action', function ($lawsuit) {// as foreach ($users as $user)
                $html = '<div class="col-md-4" ><button type = "button" class="btn btn-icon-only red" title="حذف" onclick = "deleteLawsuit(' . $lawsuit->id . ')" >
                <i class="fa fa-times" ></i ></button ></div >';

                return $html;
            })
            ->rawColumns(['action','delChk','lawsuitColor', 'session_text', 'lawsuitvalues'])
            ->toJson();

    }

    public function taskReport(Request $request)

    {
        // dd($date);
        $from = $request->from;
        $to = $request->to;
        $emp_id = $request->emp_id;
        $task_status_id = $request->task_status_id;
        $model = Task::with(['Employee', 'taskStatus']);
        if (isset($emp_id) && $emp_id != null) {
            $model = $model->where('lawyer_id', '=', $emp_id);
        }
        if (isset($from) && $from != null) {
            $model = $model->whereDate('task_date', '>=', $from);
        }
        if (isset($to) && $to != null) {
            $model = $model->whereDate('task_date', '<=', $to);
        }
        if (isset($task_status_id) && $task_status_id != null && $task_status_id != 0) {
            $model = $model->where('task_status', '=', $task_status_id);
        }
//dd($model);
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('emp_name', function ($table) {// as foreach ($users as $user)

                return $table->emp_name;
            })
            ->addColumn('statusColor', function ($task) {// as foreach ($users as $user)

                $type = 'success';
                if ($task->task_status == 1)//جديد
                    $type = 'success';
                else if ($task->task_status == 2)//
                    $type = 'info';
                else if ($task->task_status == 3)
                    $type = 'warning';
                else if ($task->task_status == 4)
                    $type = 'danger';
                return '<span class="label label-sm label-' . $type . ' " style="font-size:medium">' . $task->status_name . '</span>';
            })
            ->rawColumns(['statusColor'])
            ->toJson();
    }

    public function rateReport(Request $request)

    {
        // dd($date);
        $from = $request->from;
        $to = $request->to;
        $emp_id = $request->emp_id;
        $eval_id = $request->eval_id;
        $eval_status_id = $request->eval_status_id;
        //  dd($request->all());
        $model = EmpEvalMaster::with('evalDetails', 'Employee');
        if (isset($emp_id) && $emp_id != null && $emp_id != 0) {
            $model = $model->where('emp_id', '=', $emp_id);
        }
        if (isset($from) && $from != null) {
            $model = $model->whereDate('eval_date', '>=', $from);
        }
        if (isset($to) && $to != null) {
            $model = $model->whereDate('eval_date', '<=', $to);
        }
        if (isset($eval_id) && $eval_id != null && $eval_id != 0) {
            $model = $model->where('eval_system_id', '=', $eval_id);
        }
        if (isset($eval_status_id) && $eval_status_id != null && $eval_status_id != 0) {
            $model = $model->where('eval_status', '=', $eval_status_id);
        }

//dd($model);
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('emp_name', function ($table) {// as foreach ($users as $user)

                return $table->Employee->name;
            })
            ->addColumn('emp_national_id', function ($table) {// as foreach ($users as $user)

                return $table->Employee->national_id;
            })
            ->addColumn('system_name', function ($table) {// as foreach ($users as $user)

                return $table->system_desc;
            })
            ->addColumn('eval_result', function ($table) {// as foreach ($users as $user)

                return $table->eval_result;
            })
            //  ->rawColumns(['statusColor'])
            ->toJson();
    }

    public function generatePDF(Request $request)
    {
        // ini_set('memory_limit', '128M');
        //  ini_set("pcre.backtrack_limit", "5000000");
        $name = $request->name;
        $file_no = $request->file_no;
        $open_date = $request->open_date;
        $lawsuit_type = $request->lawsuit_type;
        $suit_type = $request->suit_type;
        $court_id = $request->court_id;
        $judge = $request->judge;
        $lawyers = $request->lawyers;
        $lawsources = $request->lawsources;
        $police_file_no = $request->police_file_no;
        $file_status = $request->file_status;
        $agent_national_id = $request->agent_national_id;
        $lawsuit_result = $request->lawsuit_result;
        $prosecution_file_no = $request->prosecution_file_no;
        // dd($agent_national_id);
        //  if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {

            if (isset($agent_national_id) && $agent_national_id != null) {
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents'])
                    ->whereHas('agents', function ($q) use ($agent_national_id) {
                        $q->where('agents.national_id', '=', $agent_national_id);
                    });

            } else
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents']);

        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();

            if (isset($agent_national_id) && $agent_national_id != null) {
                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents' => function ($q) use ($agent_national_id) {
                    $q->where('agents.national_id', '=', $agent_national_id);
                }])
                    ->whereIn('id', $files);
            } else {

                $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus', 'agents'])->whereIn('id', $files);
            }

        }
        if (isset($name) && $name != null && $name != '') {

            $agent_list = App\Agent::where('name', 'like', '%' . $name . '%')->pluck('file_id')->toArray();
            //  dd($agent_list);
            // $sql = "lawyer_id  in ";
            $lawsuit = $lawsuit->whereIn('id', $agent_list);
        }
        if (isset($file_no) && $file_no != null) {
            $lawsuit = $lawsuit->where('file_no', $file_no);

        }
        if (isset($open_date) && $open_date != null) {
            $lawsuit = $lawsuit->whereDate('open_date', $open_date);
        }
        if (isset($lawsuit_type) && $lawsuit_type != null && $lawsuit_type != 0) {
            $lawsuit = $lawsuit->where('lawsuit_type', $lawsuit_type);
        }
        if (isset($lawsuit_result) && $lawsuit_result != 0) {
            $lawsuit = $lawsuit->where('lawsuit_result', $lawsuit_result);
        }
        if (isset($suit_type) && $suit_type != null) {
            $lawsuit = $lawsuit->where('suit_type', $suit_type);
        }
        if (isset($court_id) && $court_id != null) {
            $lawsuit = $lawsuit->where('court_id', $court_id);
        }
        if (isset($judge) && $judge != null) {
            $lawsuit = $lawsuit->where('judge', $judge);
        }
        if (isset($lawyers) && $lawyers != null && $lawyers != 0) {
            // $lawsuit= $lawsuit->WhereIn('judge',$judge);
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyers)->pluck('file_id')->toArray();
            $lawsuit = $lawsuit->whereIn('id', $files);
        }
        if (isset($lawsources) && $lawsources != null && $lawsources != 0) {
            $files = LawsuitSource::where('lawyer_id', '=', $lawsources)->pluck('file_id')->toArray();

            $lawsuit = $lawsuit->whereIn('id', $files);

        }
        if (isset($prosecution_file_no) && $prosecution_file_no != null) {
            $lawsuit = $lawsuit->where('prosecution_file_no', $prosecution_file_no);
        }
        if (isset($police_file_no) && $police_file_no != null) {
            $lawsuit = $lawsuit->where('police_file_no', $police_file_no);
        }
        /*  if (isset($file_status) && $file_status != null && $file_status != 0) {

              $lawsuit = $lawsuit->where('file_status', $file_status);
          }*/
        if (isset($file_status)  && $file_status == 0) {

            $lawsuit = $lawsuit->where('file_status','!=', 4);
        }
        //  $lawsuit = $lawsuit->whereNull('deleted_at');
        $lawsuits = $lawsuit->orderBy('court_id');
        $lawsuits = $lawsuit->get();
        $html = '';
        // dd($lawsuits);
        $counter = 1;
        $curr = [0 => ' ', 1 => 'NIS', 2 => 'US', 3 => 'JOD'];
        foreach ($lawsuits as $lawsuit) {

            $html .= '<tr>';
            $html .= '<td>' . $counter++ . '</td>';
            $html .= '<td>' . (isset($lawsuit->court_name)?$lawsuit->court_name:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->agent_name)?$lawsuit->agent_name:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->respondent_name)?$lawsuit->respondent_name:' '). '</td>';
            $html .= '<td>' . (isset($lawsuit->lawsuitType->desc)?$lawsuit->lawsuitType->desc:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->lawsuit_value)?$lawsuit->lawsuit_value . ' ' . $curr[$lawsuit->currency]:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->lawsuit_value2)?$lawsuit->lawsuit_value2 . ' ' . $curr[$lawsuit->currency2]:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->file_no)?$lawsuit->file_no:' ').'</td>';
            $html .= '<td>' . (isset($lawsuit->procedure_date)?$lawsuit->procedure_date:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->session_date)?$lawsuit->session_date:' ') . '</td>';
            $html .= '<td>' . (isset($lawsuit->procedure_text)?$lawsuit->procedure_text:' '). '</td>';
            $html .= '</tr>';


        }

        $data = ['html' => $html];

        $pdf = PDF::loadView(reports_vw() . '.pdf',
            $data,
            [],
            [
                'title' => 'Report',
                'format' => 'A4-L',
                'orientation' => 'L'
            ]);
        // return $pdf->stream('certificate.pdf');
        // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');
        return $pdf->download('pdf.pdf');
//
        //return view(reports_vw() . '.pdf', $data);
//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//        return $pdf->stream();
    }
}
