<?php

namespace App\Http\Controllers;

use App\Lawsuit;
use App\Order;
use App\Procedure;
use App\Reminder;
use App\Task;
use Illuminate\Http\Request;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function remindersData()
    {
        $model = Reminder::leftJoin('lawsuits', 'lawsuits.id', '=', 'reminders.file_id')
            ->orderBy('reminder_date')->get();

//dd($model);
        $num = 1;

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

                return $model->emp_name;
            })
            ->addColumn('lawsuit_file_no', function ($model) {// as foreach ($users as $user)
                //   dd($model->LawsuitReminder->file_no);
                if ($model->file_no != null)
                    return '<a href="javascript:;" onclick="show_lawysuit(' . $model->file_id . ')" title="عرض ملف الدعوى">' . $model->file_no . '</a>';
                else
                    return '';
            })
            ->rawColumns(['action', 'reminder_type_desc', 'emp_name', 'lawsuit_file_no'])
            ->toJson();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array(33, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'sms';
            $this->data['location_title'] = 'عرض الرسائل والتنبيهات';
            $this->data['location_link'] = 'sms';
            $this->data['title'] = 'الرسائل والتنبيهات';
            $this->data['page_title'] = 'اضافة تنبية جديدة';
            $this->data['lawyers'] = getLookupEmployees();

            return view(reminder_vw() . '.create')->with($this->data);
        }
        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saveGeneral(Request $request)
    {


        $lawyers = $request->get('lawyers');
        foreach ($lawyers as $option => $value) {


            $reminder = new Reminder();

            $reminder->lawyer_id = $value;
            $reminder->org_id = auth()->user()->org_id;
            $reminder->reminder_date = $request->reminder_date;
            $reminder->reminder_type = 4;
            $reminder->event_text = $request->event_text;
            $reminder->created_by = auth()->user()->id;
            $reminder->save();
        }
        return response()->json(['success' => true]);

    }

    public function store(Request $request)
    {

        // $resLawyer = ResponsibleLawyer::where('file_id', $file_id)->delete();
        $id = $request->hdn_reminder_id;

        if ($id == '') {


            $file_id = $request->hdn_file_id;;
            $lawsuit = Lawsuit::find($file_id);
            $lawyers = $request->get('lawyers');
            foreach ($lawyers as $option => $value) {


                $reminder = new Reminder();
                $reminder->file_id = $request->hdn_file_id;
                $reminder->lawsuit_type = $lawsuit->lawsuit_type;
                $reminder->lawyer_id = $value;
                $reminder->org_id = auth()->user()->org_id;
                $reminder->reminder_date = $request->event_date;
                $reminder->reminder_type = $request->reminder_type;
                $reminder->event_id = $request->hdn_event_id;
                $reminder->event_text = $request->event_text;
                $reminder->created_by = auth()->user()->id;
                $reminder->save();
            }
        } else {

            $reminder = Reminder::find($request->hdn_reminder_id);

            $reminder->reminder_date = $request->event_date;

            $reminder->event_text = $request->event_text;

            $reminder->save();

        }
        // $table = Reminder::join('employees', 'employees.emp_id', '=', 'reminders.lawyer_id')->where('event_id', $request->hdn_procd_id)->get();
        $table = Reminder::with('employee')->where('event_id', $request->hdn_event_id)
            ->where('reminder_type', $request->reminder_type)
            ->get();
        $html = '';
        foreach ($table as $t) {
            $html .= '<tr>';
            $html .= '<td>' . $t->reminder_date . '</td>';
            $html .= '<td>' . $t->event_text . '</td>';
            $html .= '<td>' . $t->employee->name . '</td>';

            $html .= '<td><button type="button"  class="btn btn-icon-only green" ';
            $html .= 'onclick = "updateReminder(' . $t->id . ',\'' . $t->lawyer_id . '\',\'' . $t->reminder_date . '\',\'' . $t->event_text . '\')" > ';
            $html .= '<i class="fa fa-edit green-haze" ></i > </button > ';
            $html .= '<button type = "button"  class="btn btn-icon-only red" onclick = "deleteReminder(' . $t->id . ',this)" ><i class="fa fa-minus red" ></i > </button > </td ></tr > ';

        }
        return response()->json(['success' => true, 'table' => $html]);

        return response()->json(['success' => true]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
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
    public
    function reminderSource(Request $request)
    {
        $id = $request->id;

        $reminder = Reminder::find($id);

        if (isset($reminder)) {
            if ($reminder->reminder_type == 1)//procedure
            {
                $procd = Procedure::find($reminder->event_id);
                if (isset($procd))
                    $data = [
                        'file_no' => $reminder->file_no,
                        'reminder_text' => $procd->prcd_text,
                        'reminder_date' => $procd->prcd_date,
                        'comments' => $procd->comments];

            }
            else if ($reminder->reminder_type == 2)//orders
            {
                $order = Order::find($reminder->event_id);
                if (isset($order))
                    $data = [
                        'file_no' => $reminder->file_no,
                        'reminder_text' => $order->order_text,
                        'reminder_date' => $order->order_date,
                        'comments' => $order->comments];

            }
            else if ($reminder->reminder_type == 3)//task
            {

                $task = Task::find($reminder->event_id);
              //  dd($task);
                if (isset($task))
                    $data = [
                        'file_no' => '',
                        'reminder_text' => $task->task_desc,
                        'reminder_date' => $task->task_date,
                        'comments' => $task->task_desc];


            }
            else if ($reminder->reminder_type == 4)//general
            {
                $data = [
                    'file_no' => '',
                    'reminder_text' => $reminder->event_text,
                    'reminder_date' => $reminder->reminder_date,
                    'comments' => $reminder->event_text];
            }

        }
        // dd($data);
        return response()->json(['success' => true, 'data' => $data]);
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
    public function deleteReminder(Request $request)
    {
        $id = $request->id;
        $reminder = Reminder::find($id);
        if ($reminder)
            if ($reminder->delete())
                return response()->json(['success' => true]);


    }

    public function destroy($id)
    {
        //
    }
}
