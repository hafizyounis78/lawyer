<?php

namespace App\Http\Controllers;

use App\Lawsuit;
use App\Procedure;
use App\Session;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lawsuit_id = session()->get('lawsuit_id');
        // dd($lawsuit_id);
        $this->data['sub_menu'] = 'session';
        $this->data['location_title'] = 'عرض ملفات الدعوى';
        $this->data['location_link'] = 'lawsuit';
        $this->data['title'] = 'الجلسات';
        $this->data['page_title'] = 'عرض الجلسات';
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(session_vw() . '.view')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lawsuit_id = session()->get('lawsuit_id');

        $this->data['sub_menu'] = 'session';
        $this->data['location_title'] = 'عرض الجلسات';
        $this->data['location_link'] = 'session';
        $this->data['title'] = 'الجلسات';
        $this->data['page_title'] = 'اضافة جلسة جديد';
        $this->data['prcds'] = Procedure::where('file_id', $lawsuit_id)->get();

        //    $this->data['agents'] = Agent::where('file_id',$lawsuit_id)->get();
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        return view(session_vw() . '.create')->with($this->data);
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
        $session_id = $request->hdn_session_id;
        if ($session_id == '') {
            $session = New Session();
            $session->file_id = $request->get('hdn_file_id');
            $session->prcd_id = ($request->get('prcd_id') != null) ? $request->get('prcd_id') : null;
            $session->session_date = $request->get('session_date');
            $session->session_text = $request->get('session_text');
            $session->comments = $request->get('comments');
            $session->created_by = auth()->user()->id;
            $session->org_id = auth()->user()->org_id;


        } else {
            $session = Session::find($session_id);

            //  $procd->file_id = $request->get('hdn_file_id');
            // $session->prcd_id = ($request->get('prcd_id')!=null)?$request->get('prcd_id'):null;
            $session->session_date = $request->get('session_date');
            $session->session_text = $request->get('session_text');
            $session->comments = $request->get('comments');

        }
        if ($session->save()) {
            return response()->json(['success' => true, 'session_id' => $session->id]);

        } else
            return response()->json(['success' => false]);


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function sessionData()
    {
        $lawsuit_id = session()->get('lawsuit_id');
        $model = Session::where('file_id', $lawsuit_id);
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('session_date', function ($model) {// as foreach ($users as $user)
                return Carbon::parse($model->session_date)->format('Y-m-d');
            })
            ->addColumn('action', function ($model) {// as foreach ($users as $user)
                $html = '<div class="col-md-10">';
                if (in_array(66, auth()->user()->user_per))
                    $html .= '<div class="col-md-5"><a  href="' . url('/session/' . $model->id . '/edit') . '" class="btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>';
                if (in_array(67, auth()->user()->user_per))
                    $html .= '<div class="col-md-5"><form action="' . url('/session/' . $model->id) . '" method="POST">' . method_field('DELETE') . '
<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div>';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['session_date', 'action', 'sms'])
            ->toJson();
    }

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
        $this->data['sub_menu'] = 'session';
        $this->data['location_title'] = 'عرض الجلسات';
        $this->data['location_link'] = 'session';
        $this->data['title'] = 'الجلسات';
        $this->data['page_title'] = 'تعديل الجلسات';
        $this->data['prcds'] = Procedure::where('file_id', $lawsuit_id)->get();
        //     $this->data['lawyers'] = getLookupLawyers();
        $this->data['one_session'] = Session::find($id);

        if ($this->data['one_session'] != null)
            return view(session_vw() . '.edit')->with($this->data);
        return redirect()->back();

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $table = Session::find($id);
        if (isset($table))

            $table->delete();

        return Redirect::back();
    }
}
