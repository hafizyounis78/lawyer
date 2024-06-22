<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Lawsuit;
use App\Procedure;
use App\Reminder;

use App\Respondent;
use App\Sms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProcedureController extends Controller
{
    public function index()
    {
        $lawsuit_id = session()->get('lawsuit_id');
        // dd($lawsuit_id);
        $this->data['sub_menu'] = 'procedure';
        $this->data['location_title'] = 'عرض ملفات الدعوى';
        $this->data['location_link'] = 'lawsuit';
        $this->data['title'] = 'الإجراءات';
        $this->data['page_title'] = 'عرض الإجراءات';
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(procedure_vw() . '.view')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lawsuit_id = session()->get('lawsuit_id');

        $this->data['sub_menu'] = 'procedure';
        $this->data['location_title'] = 'عرض الإجراءات';
        $this->data['location_link'] = 'procedure';
        $this->data['title'] = 'الإجراءات';
        $this->data['page_title'] = 'اضافة إجراء جديد';
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['agents'] = Agent::where('file_id',$lawsuit_id)->get();
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(procedure_vw() . '.create')->with($this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $procedure_id = $request->hdn_procd_id;
        if ($procedure_id == '') {
            $procd = New Procedure();
            $procd->file_id = $request->get('hdn_file_id');
            $procd->prcd_date = $request->get('prcd_date');
            $procd->prcd_text = $request->get('prcd_text');
            $procd->comments = $request->get('comments');
            $procd->created_by = auth()->user()->id;
            $procd->org_id = auth()->user()->org_id;


        } else {
            $procd = Procedure::find($procedure_id);

            //  $procd->file_id = $request->get('hdn_file_id');
            $procd->prcd_date = $request->get('prcd_date');
            $procd->prcd_text = $request->get('prcd_text');
            $procd->comments = $request->get('comments');

        }
        if ($procd->save()) {
            return response()->json(['success' => true, 'procd_id' => $procd->id]);

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
        $lawsuit_id = session()->get('lawsuit_id');
        $this->data['sub_menu'] = 'procedure';
        $this->data['location_title'] = 'عرض الإجراءات';
        $this->data['location_link'] = 'procedure';
        $this->data['title'] = 'الإجراءات';
        $this->data['page_title'] = 'تعديل إجراء';
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['one_procedure'] = Procedure::find($id);
        $this->data['agents'] = Agent::where('file_id',$lawsuit_id)->get();
        $this->data['reminders'] = $this->getReminder($id);
        $this->data['sms_table'] = $this->getSmsTable($id);


        return view(procedure_vw() . '.edit')->with($this->data);


    }

    public function getSmsTable($id)
    {

        $sms=Sms::where('reference_id',$id)
            ->where('sms_type',1)->get();
        $html='';
        foreach ($sms as $t)
        {
            $html .= '<tr>';
            $html .= '<td>' . $t->sms_text . '</td>';
            $html .= '<td>' . $t->mobile . '</td>';
            $html .= '<td>' . $t->send_date . '</td></tr > ';


        }
        return $html;
    }
    /* public function editProcedure()
     {
        // $lawsuit_id = session()->get('lawsuit_id');
         $procedure_id = session()->get('procedure_id');
       //  dd($procedure_id);
         $this->data['sub_menu'] = 'procedure';
         $this->data['location_title'] = 'عرض الإجراءات';
         $this->data['location_link'] = 'procedure';
         $this->data['title'] = 'الإجراءات';
         $this->data['page_title'] = 'تعديل إجراء';
       //  $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
         $this->data['one_procedure'] = Procedure::find($procedure_id);
         return view(procedure_vw() . '.edit')->with($this->data);

     }*/


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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function procedureData()
    {
        $lawsuit_id = session()->get('lawsuit_id');
        $proc = Procedure::where('file_id',$lawsuit_id);
        $num = 1;
        return datatables()->of($proc)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })

            ->addColumn('action', function ($proc) {// as foreach ($users as $user)
                $html='<div class="col-md-10">';
                if (in_array(40, auth()->user()->user_per))
                    $html.= '<div class="col-md-5"><a  href="' . url('/procedure/' . $proc->id . '/edit') . '" class="btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>';
                 if (in_array(41, auth()->user()->user_per))
                    $html.='<div class="col-md-5"><form action="' . url('/procedure/' . $proc->id) . '" method="POST">'. method_field('DELETE').'
<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div>';
                $html.='</div>';
                return $html;
            })
            ->rawColumns(['reminder', 'action', 'reminder', 'sms'])
            ->toJson();
    }

    /*public function setSession(Request $request)
    {
        $url = $request->url;
        session()->put('procedure_id', '');
        $id = $request->id;
        session()->put('procedure_id', $id);
        return Redirect::to($url);
    }*/
    public function getReminder($id)
    {
        $table = Reminder::join('employees', 'employees.emp_id', '=', 'reminders.lawyer_id')
            ->where('reminder_type',1)
            ->where('event_id', $id)->get();
        // $table = Reminder::with('employee')->where('event_id', $request->hdn_procd_id)->get();
        $html = '';
        foreach ($table as $t) {
            $html .= '<tr>';
            $html .= '<td>' . $t->reminder_date . '</td>';
            $html .= '<td>' . $t->event_text . '</td>';
            $html .= '<td>' . $t->name . '</td>';

            $html .= '<td><button type="button"  class="btn btn-icon-only green" ';
            $html .= 'onclick = "updateReminder(' . $t->id . ',\'' . $t->emp_id . '\',\'' . $t->reminder_date . '\',\'' . $t->event_text . '\')" > ';
            $html .= '<i class="fa fa-edit green-haze" ></i > </button > ';
            $html .= '<button type = "button"  class="btn btn-icon-only red" onclick = "deleteReminder(' . $t->id . ',this)" ><i class="fa fa-minus red" ></i > </button > </td ></tr > ';


        }
        return $html;
    }

    public function destroy($id)
    {
        $procedure=Procedure::find($id);
        if(isset($procedure))

            $procedure->delete();

            return Redirect::back();
    }
}
