<?php

namespace App\Http\Controllers;

use App\FileUpload;
use App\Lawsuit;
use App\Menu;
use App\Reminder;
use App\ResponsibleLawyer;
use App\Session;
use App\Task;
use App\TaskStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;


use App\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

        $this->middleware('auth');


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $this->data['sub_menu'] = 'home';
        // $this->data['task_statuses'] = TaskStatus::all();
        $this->data['user_archs'] = $this->getArch();


        return view(admin_vw() . '.home')->with($this->data);

    }

    public function getArch()
    {
        $files = FileUpload::where('file_share', 1)->orderBy('file_title')
            ->get();
        $html = '';
        $i = 0;

        foreach ($files as $file) {
            $html .= '<tr><td>' . ++$i . '</td>';
            $html .= '<td><a href="' . url('/public/storage/' . $file->file_link) . '">' . $file->file_title . '</a></td>';
            $html .= '<td>' . $file->type_desc . '</td>';
            $html .= '<td>' . $file->file_loc . '</td>';
            $html .= '<td>' . $file->file_note . '</td>';
            $html .= '<td>' . $file->created_at->format('d/m/Y') . '</td></tr>';
        }
        return $html;
    }


    public function lawsuitBar($start = null, $end = null)
    {
        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {
            //  if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $lawsuit = DB::table('lawsuits')
                ->select(DB::raw('(select lawsuit_types.desc from lawsuit_types where lawsuit_types.id=lawsuits.lawsuit_type) as type_name,
            count(lawsuits.lawsuit_type)  AS COUNT'))
                ->groupBy('lawsuit_type');
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->get();
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();
            // $lawsuit = Lawsuit::whereIn('id', $files)->groupBy('lawsuit_type')->count();
            $lawsuit = DB::table('lawsuits')
                ->select(DB::raw('(select lawsuit_types.desc from lawsuit_types where lawsuit_types.id=lawsuits.lawsuit_type) as type_name,
            count(lawsuits.lawsuit_type)  AS COUNT'))
                ->whereIn('id', $files)
                ->groupBy('lawsuit_type');
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->get();
        }
        //dd($lawsuit);
        return response()->json(['data' => $lawsuit]);
    }

    public function lawsuitBar2($start = null, $end = null)
    {
        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {

            //  if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $lawsuit = DB::table('lawsuits')
                ->select(DB::raw('(select lawsuit_types.desc from lawsuit_types where lawsuit_types.id=lawsuits.lawsuit_type) as type_name,
            count(lawsuits.lawsuit_type)  AS COUNT'))
                ->groupBy('lawsuit_type');
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->get();
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();
            // $lawsuit = Lawsuit::whereIn('id', $files)->groupBy('lawsuit_type')->count();
            $lawsuit = DB::table('lawsuits')
                ->select(DB::raw('(select lawsuit_types.desc from lawsuit_types where lawsuit_types.id=lawsuits.lawsuit_type) as type_name,
            count(lawsuits.lawsuit_type)  AS COUNT'))
                ->whereIn('id', $files)
                ->groupBy('lawsuit_type');
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->get();
        }
        //dd($lawsuit);
        return $lawsuit;
    }

    public function taskData(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        if ((auth()->user()->user_role != 1)) {
            $task = Task::with(['taskStatus', 'Employee']);
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $task = Task::with(['taskStatus', 'Employee'])->where('lawyer_id', '=', $lawyer_id);
        }
        if (isset($start) && isset($end))
            $task = Task::whereBetween('task_date', [$start, $end]);
        else
            $task = Task::whereDate('task_date', '=', Carbon::today());
        /*join('employees', 'emp_id', '=', 'lawyer_id')
            ->join('task_statuses', 'task_statuses.id', '=', 'task_status');*/
        $num = 1;

        return datatables()->of($task)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('task_desc', function ($table) {
                return '<a data-toggle="modal" href="#taskModal"
                                           onclick="show_task(\'' . $table->task_desc . '\',\'' . $table->task_date . '\')" title="عرض المهمة">' . $table->task_desc . '</a>';
            })
            ->filterColumn('employee_name', function ($query, $keyword) {
                $emp_list = Employee::where('name', 'like', '%' . $keyword . '%')->pluck('emp_id')->toArray();
                // dd($emp_list);
                // $sql = "lawyer_id  in ";
                $query->whereIn('lawyer_id', $emp_list);
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
            ->addColumn('employee_name', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->Employee->name))
                    return $lawsuit->Employee->name;
                return '';
            })
            ->orderColumn('employee_name', 'lawyer_id $1')
            ->orderColumn('statusColor', 'task_status $1')
            /* ->editColumn('task_date', function ($task) {// as foreach ($users as $user)

                 $dt = new \DateTime($task->ofr_end);

                 return $dt->format('Y-m-d');
                 //->format('Y-m-d');

             })*/
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                $task_statuses = TaskStatus::all();
                $html = '<div class="btn-group"><button class="btn btn-xs purple-plum dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> تحكم
                                                <i class="fa fa-angle-down"></i></button><ul class="dropdown-menu pull-left" role="menu">';
                foreach ($task_statuses as $task_statuse)

                    $html .= '<li ><a href = "javascript:;"  onclick = "update_status(' . $task_statuse->id . ',' . $table->id . ')" >' . $task_statuse->desc . '</a></li >';

                $html .= '</ul></div>';
                return $html;
            })
            ->rawColumns(['statusColor', 'action', 'name', 'task_desc'])
            ->toJson();
    }

    public function remindersData(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {
            //if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $model = Reminder::query();
            // dd($sessions);
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $model = Reminder::where('lawyer_id', $lawyer_id);
        }
        if (isset($start) && isset($end))
            $model = $model->whereBetween('reminder_date', [$start, $end]);
        else
            $model = $model->whereDate('reminder_date', '=', Carbon::today());
        $num = 1;

        $model = $model->orderBy('reminder_date', 'desc');
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('reminder_type_desc', function ($model) {// as foreach ($users as $user)
                $html = '';
                if ($model->reminder_type == 1)//procedure
                    $html = '<span class="bg-font-red btn bg-red">' . $model->reminder_desc . '</span>';
                else if ($model->reminder_type == 2)//orders
                    $html = '<span class="bg-font-red btn bg-blue">' . $model->reminder_desc . '</span>';
                else if ($model->reminder_type == 3)//task
                    $html = '<span class="bg-font-red btn bg-green">' . $model->reminder_desc . '</span>';
                else if ($model->reminder_type == 4)//general
                    $html = '<span class="bg-font-red btn bg-yellow">' . $model->reminder_desc . '</span>';


                return $html;
            })
            ->addColumn('emp_name', function ($model) {// as foreach ($users as $user)
                if ($model->emp_name != '')
                    return $model->emp_name;
                return '';
            })
            ->addColumn('lawsuit_file_no', function ($model) {// as foreach ($users as $user)
                //   dd($model->LawsuitReminder->file_no);
                if ($model->file_id !== null)
                    return '<a href="javascript:;" onclick="show_lawysuit(' . $model->file_id . ')" title="عرض ملف الدعوى">' . $model->file_no . '</a>';
                else
                    return '';
            })
            ->rawColumns(['action', 'reminder_type_desc', 'emp_name', 'lawsuit_file_no'])
            ->toJson();

    }

    public function sessionData(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;
        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {
            //if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $model = Session::with('Lawsuit');
            // dd($sessions);
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();
            $model = Session::with('Lawsuit')->whereIn('file_id', $files);
        }

        if (isset($start) && isset($end))
            $model = $model->whereBetween('session_date', [$start, $end]);
        else
            $model = $model->whereDate('session_date', '=', Carbon::today());
        //dd($model->get());
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('file_color_desc', function ($model) {// as foreach ($users as $user)
                //   dd($model->LawsuitReminder->file_no);
                if ($model->file_id != null)
                    return ' <span class="label label-sm " style="font-size: medium;background-color:' . $model->lawsuit->file_color . '">' . $model->lawsuit->type_desc . ' </span>';
                else
                    return '';
            })
            ->addColumn('lawsuit_file_no', function ($model) {// as foreach ($users as $user)
                //   dd($model->LawsuitReminder->file_no);
                if ($model->file_id != null)
                    return '<a href="javascript:;" onclick="show_lawysuit(' . $model->file_id . ')" title="عرض ملف الدعوى">' . $model->lawsuit->file_no . '</a>';
                else
                    return '';
            })
            ->rawColumns(['reminder', 'lawsuit_file_no', 'file_color_desc'])
            ->toJson();
    }

    public function updateTaskStatus(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $status = $request->status;
        $task = Task::find($id);
        if (isset($task)) {
            $task->task_status = $status;
            $task->task_change_date = date('Y-m-d H:i:s');
        }
        $task->save();
        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {
            // if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            //  $usertasks = Task::latest()->take(10)->get();
            $usertasks = Task::whereDate('task_date', '=', Carbon::today())->get();
        } else {
            $usertasks = Task::where('lawyer_id', auth()->user()->emp_id)
                ->whereDate('task_date', '=', Carbon::today())->get();

        }
        $task_statuses = TaskStatus::all();
        $html = '';
        $i = 0;


        return response()->json(['success' => true]);
    }

    public function notifications(Request $request)
    {

        if ((auth()->user()->user_role != 1)) {// || auth()->user()->user_role == 2)) {
            //if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $model = Reminder::query();
            $noti_count = Reminder::query();
            // dd($sessions);
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $model = Reminder::where('lawyer_id', $lawyer_id);
            $noti_count = Reminder::where('lawyer_id', $lawyer_id);
        }

        $model = $model->whereDate('reminder_date', '=', Carbon::today());
        $model = $model->orderBy('reminder_date')->get();
        $noti_count = $noti_count->whereDate('reminder_date', '=', Carbon::today())->count();

        $html = '';
        foreach ($model as $item) {
            if ($item->file_id != '' && $item->file_id != null)
                $html .= '<li><a href="javascript:;" onclick="show_lawysuit(' . $item->file_id . ')" title="عرض ملف الدعوى">';
            else
                $html .= '<li><a href="javascript:;">';
            $html .= '<span class="time">' . $item->reminder_date . '</span>';
            $html .= '<span class="details"><span class="label label-sm label-icon label-info"><i class="fa fa-bullhorn"></i></span>';
            $html .= $item->event_text . '</span>';
            $html .= '</a></li>';

        }
        /* ->addColumn('reminder_type_desc', function ($model) {// as foreach ($users as $user)
             $html = '';
             if ($model->reminder_type == 1)//procedure
                 $html = '<span class="bg-font-red btn bg-red">' . $model->reminder_desc . '</span>';
             else if ($model->reminder_type == 2)//orders
                 $html = '<span class="bg-font-red btn bg-blue">' . $model->reminder_desc . '</span>';
             else if ($model->reminder_type == 3)//task
                 $html = '<span class="bg-font-red btn bg-green">' . $model->reminder_desc . '</span>';
             else if ($model->reminder_type == 4)//general
                 $html = '<span class="bg-font-red btn bg-yellow">' . $model->reminder_desc . '</span>';


             r
         })*/
        return response()->json(['success' => true, 'data' => $html, 'noti_count' => $noti_count]);

    }

}
