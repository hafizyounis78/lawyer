<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Reminder;
use App\Task;
use App\TaskStatus;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        if (in_array(10, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'task';
            $this->data['location_title'] = 'عرض المهام';
            $this->data['location_link'] = 'task';
            $this->data['title'] = 'المهام';
            $this->data['page_title'] = 'عرض المهام';
            return view(task_vw() . '.view')->with($this->data);
        }
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array(11, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'task';
            $this->data['location_title'] = 'عرض المهام';
            $this->data['location_link'] = 'task';
            $this->data['title'] = 'المهام';
            $this->data['page_title'] = 'اضافة مهمة جديد';
            $this->data['lawyers'] = getLookupEmployees();
            return view(task_vw() . '.create')->with($this->data);
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        /* $task_id = $request->get('hdn_task_id');
         if($task_id == '')
         {*/
        $lawyers = $request->get('lawyers');
        foreach ($lawyers as $option => $value) {
            $task = New Task();
            $task->lawyer_id = $value;
            $task->task_desc = $request->get('task_desc');
            $task->task_date = $request->get('task_date');
            $task->task_status = 1;
            $task->org_id = auth()->user()->org_id;
            $task->created_by = auth()->user()->id;
            $task->save();

            $reminder = new Reminder();

            $reminder->lawyer_id = $value;
            $reminder->org_id = auth()->user()->org_id;
            $reminder->reminder_date = $request->get('task_date');
            $reminder->reminder_type = 3;
            $reminder->event_id = $task->id;
            $reminder->event_text = $request->get('task_desc');
            $reminder->created_by = auth()->user()->id;
            $reminder->save();
        }
        /*}
        else {
            $lawyers = $request->get('lawyers');
            foreach ($lawyers as $option => $value)
            {
                $task = New Task();
                $task->lawyer_id = $value;
                $task->task_desc = $request->get('task_desc');
                $task->task_date = $request->get('task_date');
                $task->org_id = auth()->user()->org_id;
                $task->save();
            }
        }*/


        if ($task->save()) {
            return response()->json(['success' => true]);

        } else
            return response()->json(['success' => false]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['sub_menu'] = 'task';
        $this->data['location_title'] = 'عرض المهام';
        $this->data['location_link'] = 'task';
        $this->data['title'] = 'المهام';
        $this->data['page_title'] = 'تعديل مهمة';
        $this->data['lawyers'] = getLookupEmployees();
        $this->data['task_statuses'] = TaskStatus::all();
        $this->data['one_task'] = Task::find($id);
        return view(task_vw() . '.edit')->with($this->data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $task = Task::find($id);
        $task->task_desc = $request->get('task_desc');
        $task->task_date = $request->get('task_date');
        $task->task_status = $request->get('task_status');

        $task->save();

        $reminder = Reminder::where('reminder_type', 3)
            ->where('event_id', $id)
            ->where('org_id', auth()->user()->org_id)
            ->first();
        $reminder->reminder_date = $request->get('task_date');
        $reminder->event_text = $request->get('task_desc');
        $reminder->save();
        return response()->json(['success' => true]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function taskData()
    {
        if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $task = Task::with(['taskStatus', 'Employee']);
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $task = Task::with(['taskStatus', 'Employee'])->where('lawyer_id','=',$lawyer_id);
        }
        /*join('employees', 'emp_id', '=', 'lawyer_id')
            ->join('task_statuses', 'task_statuses.id', '=', 'task_status');*/
        $num = 1;
        return datatables()->of($task)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->filterColumn('task_desc', function ($query, $keyword) {
                $sql = "task_desc  like ?";
                if ($keyword != '')
                    $query->whereRaw($sql, ["%{$keyword}%"]);
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

                $html = '<div class="col-md-12">';
                if (in_array(46, auth()->user()->user_per))
                    $html .= '<div class="col-md-6"><a  href="' . url('/task/' . $table->id . '/edit') . '" class="btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>';
                if (in_array(47, auth()->user()->user_per))
                    $html .= '<div class="col-md-3" ><button type = "button" class="btn btn-icon-only red" 
onclick = "deleteTask(' . $table->id . ')" ><i class="fa fa-times" ></i ></button ></div >';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['statusColor', 'action', 'name'])
            ->toJson();
    }

   /* public
    function destroy($id)
    {
        //dd('hi');
        $task = Task::find($id);
        if ($task)
            if ($task->delete())
                return redirect()->to(task_vw() . '/');
    }*/
   public function deleteTask(Request $request)
    {
        //dd('hi');
        $id=$request->id;
        $task = Task::find($id);
        if ($task)
            if ($task->delete())
                return redirect()->to(task_vw() . '/');
    }
}
