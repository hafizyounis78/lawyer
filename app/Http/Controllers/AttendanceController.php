<?php

namespace App\Http\Controllers;

use App\AttendanceSheet;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(14, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'attendance-display';
            $this->data['location_title'] = 'عرض حركات الموظفين';
            $this->data['location_link'] = 'attendance';
            $this->data['title'] = 'الحضور والإنصراف';
            $this->data['page_title'] = 'عرض حركات الموظفين';
            $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
            return view(attendance_vw() . '.view')->with($this->data);
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
        if (in_array(50, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'attendance-display';
            $this->data['location_title'] = 'عرض حركات الموظفين';
            $this->data['location_link'] = 'attendance';
            $this->data['title'] = 'الحضور والإنصراف';
            $this->data['page_title'] = 'اضافة حركات الموظفين';
            $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
            return view(attendance_vw() . '.create')->with($this->data);
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
        $emp_id = $request->emp_id;
        if ($emp_id == 0) {
            $employees = Employee::where('org_id', auth()->user()->org_id)->get();
            foreach ($employees as $employee) {
                $attend = new AttendanceSheet();
                $attend->emp_id = $employee->emp_id;
                $attend->date = $request->attend_date;
                $attend->in_time = $request->in_time;
                $attend->out_time = $request->out_time;
                $attend->created_by = auth()->user()->id;
                $attend->save();
            }
            return response()->json(['success' => true]);
        } else {
            $attend = new AttendanceSheet();
            $attend->emp_id = $request->emp_id;
            $attend->date = $request->attend_date;
            $attend->in_time = $request->in_time;
            $attend->out_time = $request->out_time;
            $attend->created_by = auth()->user()->id;
            if ($attend->save())
                return response()->json(['success' => true]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function attendanceData(Request $request)
    {

        $from = $request->from;
        $to = $request->to;
        $emp_id = $request->emp_id;
        $model = AttendanceSheet::with('Employee');
        if (isset($emp_id) && $emp_id != 0)
            $model = $model->where('emp_id', '=', $emp_id);
        if (isset($from) && $from != null) {
            $model = $model->whereDate('date', '>=', $from);
        }
        if (isset($to) && $to != null) {
            $model = $model->whereDate('date', '<=', $to);
        }
        if ($from == '' && $to == '')
            $model = $model->whereDate('date', '=', Carbon::today());
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
            ->addColumn('job_desc', function ($model) {// as foreach ($users as $user)

                return $model->Employee->job_desc;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function newAttendData(Request $request)
    {

        $from = $request->from;
        //    $to = $request->to;
        $emp_id = $request->emp_id;
        $model = AttendanceSheet::with('Employee');
        if (isset($emp_id) && $emp_id != 0)
            $model = $model->where('emp_id', '=', $emp_id);
        if (isset($from) && $from != null) {
            $model = $model->whereDate('date', '=', $from);
        }

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
            ->addColumn('in_time', function ($table) {// as foreach ($users as $user)

                return '<input id="inTime' . $table->id . '" type="text" value="' . $table->in_time . '" onblur="changeInTime(' . $table->id . ')">';
            })
            ->addColumn('out_time', function ($table) {// as foreach ($users as $user)

                return '<input id="outTime' . $table->id . '" type="text" value="' . $table->out_time . '" onblur="changeOutTime(' . $table->id . ')">';
            })
            ->addColumn('job_desc', function ($model) {// as foreach ($users as $user)

                return $model->Employee->job_desc;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '<div class="col-md-6" ><button type = "button" class="btn btn-icon-only red" onclick = "deleteRecord(' . $table->id . ')" ><i class="fa fa-times" ></i ></button ></div >';


            })
            ->rawColumns(['action', 'in_time', 'out_time'])
            ->toJson();
    }

    public
    function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    /*   public function getAttendByDate(Request $request)
       {
           $attend_date=$request->attend_date;
           $attendance=AttendanceSheet::where('date',$attend_date);

       }*/
    public
    function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy($id)
    {
        //
    }

    public function change_inTime(Request $request)
    {
        $id = $request->id;
        $newTime = $request->newTime;
        $attend = AttendanceSheet::find($id);
        if (isset($attend)) {
            $attend->in_time = $newTime;

        }
        if ($attend->save())
            return response()->json(['success' => true]);

    }

    public function change_outTime(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $newTime = $request->newTime;
        $attend = AttendanceSheet::find($id);
        if (isset($attend)) {
            $attend->out_time = $newTime;

        }
        if ($attend->save())
            return response()->json(['success' => true]);

    }

    public function attend_delete(Request $request)
    {

        $id = $request->id;

        $attend = AttendanceSheet::find($id);
        if (isset($attend))
            if ($attend->delete())
                return response()->json(['success' => true]);

    }
}
