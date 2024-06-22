<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Lawsuit;
use App\Order;
use App\Reminder;
use App\Sms;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $lawsuit_id = session()->get('lawsuit_id');
        $this->data['sub_menu'] = 'order';
        $this->data['location_title'] = 'عرض ملفات الدعوى';
        $this->data['location_link'] = 'lawsuit';
        $this->data['title'] = 'الطلبات';
        $this->data['page_title'] = 'عرض الطلبات';
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(order_vw() . '.view')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lawsuit_id = session()->get('lawsuit_id');

        $this->data['sub_menu'] = 'order';
        $this->data['location_title'] = 'عرض الطلبات';
        $this->data['location_link'] = 'order';
        $this->data['title'] = 'الطلبات';
        $this->data['page_title'] = 'اضافة طلب جديد';
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['agents'] = Agent::where('file_id',$lawsuit_id)->get();
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(order_vw() . '.create')->with($this->data);
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
        $order_id = $request->hdn_order_id;
        if ($order_id == '') {
            $order = New Order();
            $order->file_id = $request->get('hdn_file_id');
            $order->order_id = $request->get('order_id');
            $order->order_date = $request->get('order_date');
            $order->order_text = $request->get('order_text');
            $order->comments = $request->get('comments');
            $order->created_by = auth()->user()->id;
            $order->org_id = auth()->user()->org_id;


        } else {
            $order = Order::find($order_id);

            //  $procd->file_id = $request->get('hdn_file_id');
            $order->order_id = $request->get('order_id');
            $order->order_date = $request->get('order_date');
            $order->order_text = $request->get('order_text');
            $order->comments = $request->get('comments');

        }
        if ($order->save()) {
            return response()->json(['success' => true, 'order_id' => $order->id]);

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
        $this->data['sub_menu'] = 'order';
        $this->data['location_title'] = 'عرض الطلبات';
        $this->data['location_link'] = 'order';
        $this->data['title'] = 'الطلبات';
        $this->data['page_title'] = 'تعديل طلب';
        //$this->data['one_lawsuit'] = Lawsuit::find($id);
        $this->data['one_order'] = Order::find($id);
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['agents'] = Agent::where('file_id',$lawsuit_id)->get();
        $this->data['sms_table'] = $this->getSmsTable($id);
        $this->data['reminders'] = $this->getReminder($id);
        return view(order_vw() . '.edit')->with($this->data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getReminder($id)
    {
        $table = Reminder::join('employees', 'employees.emp_id', '=', 'reminders.lawyer_id')
            ->where('reminder_type', 2)
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

    public function getSmsTable($id)
    {

        $sms = Sms::where('reference_id', $id)
            ->where('sms_type', 2)->get();
        $html = '';
        foreach ($sms as $t) {
            $html .= '<tr>';
            $html .= '<td>' . $t->sms_text . '</td>';
            $html .= '<td>' . $t->mobile . '</td>';
            $html .= '<td>' . $t->send_date . '</td></tr > ';


        }
        return $html;
    }

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
    public function orderData()
    {
        $order = Order::all();
        $num = 1;
        return datatables()->of($order)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                $html = '<div class="col-md-10">';
                if (in_array(40, auth()->user()->user_per))
                    $html .= '<div class="col-md-5"><a  href="' . url('/order/' . $table->id . '/edit') . '" class="btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>';
                if (in_array(41, auth()->user()->user_per))
                    $html .= '<div class="col-md-5"><form action="' . url('/order/' . $table->id) . '" method="POST">' . method_field('DELETE') . '
<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div>';
                $html .= '</div>';
                return $html;

            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function destroy($id)
    {

    }
}
