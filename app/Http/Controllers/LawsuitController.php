<?php

namespace App\Http\Controllers;

use App\Agent;
use App\FileLocation;
use App\FileStatus;
use App\Lawsuit;
use App\LawsuitResult;
use App\LawsuitSource;
use App\LawsuitUploadfile;
use App\Order;
use App\Reminder;
use App\Respondent;
use App\Procedure;
use App\ResponsibleLawyer;
use App\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\New_;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use PDF;

class LawsuitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // session()->flash('lawsuit_id');
        if (in_array(8, auth()->user()->user_per)) {


            if (auth()->user()->user_per)
                $this->data['sub_menu'] = 'lawsuit';
            $this->data['open_files'] = $this->getFilesCount(1);
            $this->data['session_files'] = $this->getFilesCount(2);
            $this->data['closed_files'] = $this->getFilesCount(3);
            $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
            $this->data['FileStatuses'] = getLookupFileStatus();
            /* $this->data['result1'] = $this->getResultCount(1);
             $this->data['result2'] = $this->getResultCount(2);
             $this->data['result3'] = $this->getResultCount(3);*/
            $this->data['location_title'] = 'عرض ملفات الدعوى';
            $this->data['location_link'] = 'lawsuit';
            $this->data['title'] = 'الدعاوي';
            $this->data['page_title'] = 'عرض ملفات الدعوى';
            return view(lawsuit_vw() . '.view')->with($this->data);
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
        if (in_array(9, auth()->user()->user_per)) {
            session()->put('lawsuit_id', '');
            $this->data['sub_menu'] = 'lawsuit';
            $this->data['location_title'] = 'عرض ملفات الدعوى';
            $this->data['location_link'] = 'lawsuit';
            $this->data['title'] = 'الدعاوي';
            $this->data['page_title'] = 'فتح دعوى جديدة ';
            $this->data['lawyers'] = getLookupLawyers();
            $this->data['externalEmps'] = getLookupExtEmployees();
            $this->data['courts'] = getLookupCourts();
            $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
            $this->data['lawsuitResults'] = LawsuitResult::get();
            $this->data['FileStatuses'] = FileStatus::get();
            $this->data['file_counter'] = $this->getFileCounter();
            $this->data['FileLocations'] = FileLocation::get();
            $this->data['year'] = Carbon::now()->year;
            //dd(Carbon::now()->year);
            return view(lawsuit_vw() . '.create')->with($this->data);
        }
        return redirect()->back();
    }

    public function getFileCounter()
    {

        $counter = \App\Lawsuit::whereYear('created_at', Carbon::now()->year)
            ->max('file_counter');
        if ($counter == null)
            return 1;
        return $counter + 1;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $file_id = $request->hdn_file_no;
        if ($file_id == '') {

            $lawsuit = new Lawsuit();
            $lawsuit->file_no = $request->get('file_no');
            $lawsuit->file_counter = $request->get('file_counter');
            $lawsuit->open_date = date('Y-m-d H:i:s');
            $lawsuit->court_id = $request->get('court_id');
            $lawsuit->org_id = auth()->user()->org_id;
            $lawsuit->judge = $request->get('judge');
            $lawsuit->lawsuit_type = $request->get('lawsuit_type');
            $lawsuit->suit_type = $request->get('suit_type');
            $lawsuit->lawsuit_value = $request->get('lawsuit_value');
            $lawsuit->currency = $request->get('currency');
            $lawsuit->lawsuit_value2 = $request->get('lawsuit_value2');
            $lawsuit->currency2 = $request->get('currency2');
            $lawsuit->file_status = ($request->get('lawsuit_result') != null) ? $request->get('lawsuit_result') : 1;
            $lawsuit->file_location = ($request->get('file_location') != null) ? $request->get('file_location') : 1;
            $lawsuit->prosecution_file_no = $request->get('prosecution_file_no');
            $lawsuit->complaint_no = $request->get('complaint_no');
            $lawsuit->lawsuit_result = ($request->get('lawsuit_result') != null) ? $request->get('lawsuit_result') : null;

            $lawsuit->court_file_no = $request->get('court_file_no');
            $lawsuit->appeal_file_no = $request->get('appeal_file_no');
            $lawsuit->veto_file_no = $request->get('veto_file_no');
            $lawsuit->executive_file_no = $request->get('executive_file_no');
            $lawsuit->police_file_no = $request->get('police_file_no');
            $lawsuit->noti_file_no = $request->get('noti_file_no');
            $lawsuit->lawsuit_note = $request->get('lawsuit_note');
            $lawsuit->created_by = auth()->user()->id;
            $lawyers = $request->get('lawyers');


            if ($lawsuit->save()) {
                if ($request->has('lawyers')) {
                    foreach ($lawyers as $option => $value) {
                        $newlawyer = new ResponsibleLawyer();
                        $newlawyer->lawyer_id = $value;
                        $newlawyer->file_id = $lawsuit->id;
                        $newlawyer->org_id = auth()->user()->org_id;
                        $newlawyer->created_by = auth()->user()->id;
                        $newlawyer->save();
                    }
                }
                if ($request->has('lawsources')) {
                    $lawsources = $request->get('lawsources');;
                    foreach ($lawsources as $option => $value) {
                        $lawsource = new LawsuitSource();
                        $lawsource->lawyer_id = $value;
                        $lawsource->file_id = $lawsuit->id;
                        $lawsource->org_id = auth()->user()->org_id;
                        $lawsource->created_by = auth()->user()->id;
                        $lawsource->save();
                    }
                }

                session()->put('lawsuit_id', $lawsuit->id);
                return response()->json(['success' => true, 'file_id' => $lawsuit->id]);

            } else
                return response()->json(['success' => false]);
            //  return redirect()->to(lawsuit_vw());
        } else {
//dd($request->get('file_status'));
            $lawsuit = Lawsuit::find($file_id);
            $lawsuit->file_no = $request->get('file_no');
            $lawsuit->court_id = $request->get('court_id');
            $lawsuit->org_id = auth()->user()->org_id;
            $lawsuit->judge = $request->get('judge');
            $lawsuit->lawsuit_type = $request->get('lawsuit_type');
            $lawsuit->suit_type = $request->get('suit_type');
            $lawsuit->file_status = ($request->get('file_status') != null) ? $request->get('file_status') : 1;
            $lawsuit->lawsuit_result = ($request->get('lawsuit_result') != null) ? $request->get('lawsuit_result') : null;
            $lawsuit->lawsuit_value = $request->get('lawsuit_value');
            $lawsuit->currency = $request->get('currency');
            $lawsuit->lawsuit_value2 = $request->get('lawsuit_value2');
            $lawsuit->currency2 = $request->get('currency2');
            $lawsuit->file_location = ($request->get('file_location') != null) ? $request->get('file_location') : 1;
            $lawsuit->prosecution_file_no = $request->get('prosecution_file_no');
            $lawsuit->complaint_no = $request->get('complaint_no');
            $lawsuit->court_file_no = $request->get('court_file_no');
            $lawsuit->appeal_file_no = $request->get('appeal_file_no');
            $lawsuit->veto_file_no = $request->get('veto_file_no');
            $lawsuit->executive_file_no = $request->get('executive_file_no');
            $lawsuit->police_file_no = $request->get('police_file_no');
            $lawsuit->noti_file_no = $request->get('noti_file_no');
            $lawsuit->lawsuit_note = $request->get('lawsuit_note');

            $lawyers = $request->get('lawyers');


            if ($lawsuit->save()) {
                if ($request->has('lawyers')) {
                    $resLawyer = ResponsibleLawyer::where('file_id', $file_id)->delete();


                    foreach ($lawyers as $option => $value) {
                        $newlawyer = new ResponsibleLawyer();
                        $newlawyer->lawyer_id = $value;
                        $newlawyer->file_id = $lawsuit->id;
                        $newlawyer->org_id = auth()->user()->org_id;
                        $newlawyer->created_by = auth()->user()->id;
                        $newlawyer->save();
                    }
                }
                if ($request->has('lawsources')) {
                    $lawsources = $request->get('lawsources');
                    $sourceLawyer = LawsuitSource::where('file_id', $file_id)->delete();

                    foreach ($lawsources as $option => $value) {
                        $lawsource = new LawsuitSource();
                        $lawsource->lawyer_id = $value;
                        $lawsource->file_id = $lawsuit->id;
                        $lawsource->org_id = auth()->user()->org_id;
                        $lawsource->created_by = auth()->user()->id;
                        $lawsource->save();
                    }
                }


                return response()->json(['success' => true, 'file_id' => $lawsuit->id]);

            } else
                return response()->json(['success' => false]);
            //  return redirect()->to(lawsuit_vw());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    public function editLawsuit()
    {


        $lawsuit_id = session()->get('lawsuit_id');
        // dd($lawsuit_id);
        $this->data['sub_menu'] = 'lawsuit';
        $this->data['location_title'] = 'عرض ملفات الدعوى';
        $this->data['location_link'] = 'lawsuit';
        $this->data['title'] = 'الدعاوي';
        $this->data['page_title'] = 'تعديل بيانات الدعوى  ';
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        $this->data['lawsuit_id'] = $lawsuit_id;
        //  dd($this->data['one_lawsuit']);
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['lawsuit_lawyers'] = getLookupResponsibleLawyers($lawsuit_id);
        //  dd($this->data['lawsuit_lawyers']);
        $this->data['externalEmps'] = getLookupExtEmployees();
        $this->data['lawsuit_sources'] = getLookupLawsuitSource($lawsuit_id);
        $this->data['courts'] = getLookupCourts();
        $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
        $this->data['lawsuitResults'] = LawsuitResult::get();
        $this->data['FileStatuses'] = FileStatus::get();
        $this->data['FileLocations'] = FileLocation::get();
        $this->data['agents'] = getAgents($lawsuit_id);
        $this->data['respondents'] = getRespondents($lawsuit_id);
        $this->data['files'] = getFiles($lawsuit_id);

        return view(lawsuit_vw() . '.edit')->with($this->data);

    }

    public function showLawsuit()
    {


        $lawsuit_id = session()->get('lawsuit_id');
        // dd($lawsuit_id);
        $this->data['sub_menu'] = 'lawsuit';
        $this->data['location_title'] = 'عرض ملفات الدعوى';
        $this->data['location_link'] = 'lawsuit';
        $this->data['title'] = 'الدعاوي';
        $this->data['page_title'] = 'عرض بيانات الدعوى  ';
        $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
        $this->data['lawsuit_id'] = $lawsuit_id;
        $this->data['lawsuit_id'] = $lawsuit_id;
        //  dd($this->data['one_lawsuit']);
        $this->data['lawyers'] = getLookupLawyers();
        $this->data['lawsuit_lawyers'] = getLookupResponsibleLawyers($lawsuit_id);
        //  dd($this->data['lawsuit_lawyers']);
        $this->data['externalEmps'] = getLookupExtEmployees();
        $this->data['lawsuit_sources'] = getLookupLawsuitSource($lawsuit_id);
        $this->data['courts'] = getLookupCourts();
        $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
        $this->data['lawsuitResults'] = LawsuitResult::get();
        $this->data['FileStatuses'] = FileStatus::get();
        $this->data['FileLocations'] = FileLocation::get();
        $this->data['agents'] = getAgentsPrint($lawsuit_id);
        $this->data['respondents'] = getRespondentsPrint($lawsuit_id);
        $this->data['files'] = getFiles($lawsuit_id);
        return view(lawsuit_vw() . '.index')->with($this->data);
        //return redirect()->to(lawsuit_vw() . '/index')->with($this->data);

    }

    public function printLawsuit()
    {


        $lawsuit_id = session()->get('lawsuit_id');
        // dd($lawsuit_id);
        if ($lawsuit_id != '') {


            $this->data['sub_menu'] = 'lawsuit';
            $this->data['location_title'] = 'عرض ملفات الدعوى';
            $this->data['location_link'] = 'lawsuit';
            $this->data['title'] = 'الدعاوي';
            $this->data['page_title'] = 'عرض بيانات الدعوى  ';
            $this->data['one_lawsuit'] = Lawsuit::find($lawsuit_id);
            $this->data['lawsuit_id'] = $lawsuit_id;
            $this->data['lawsuit_id'] = $lawsuit_id;
            //  dd($this->data['one_lawsuit']);
            $this->data['lawyers'] = getLookupLawyers();
            $this->data['lawsuit_lawyers'] = getLookupResponsibleLawyers($lawsuit_id);
            //  dd($this->data['lawsuit_lawyers']);
            $this->data['externalEmps'] = getLookupExtEmployees();
            $this->data['lawsuit_sources'] = getLookupLawsuitSource($lawsuit_id);
            $this->data['courts'] = getLookupCourts();
            $this->data['lawsuitTypes'] = getLookupLawsuitTypes();
            $this->data['lawsuitResults'] = LawsuitResult::get();
            $this->data['FileStatuses'] = FileStatus::get();
            $this->data['FileLocations'] = FileLocation::get();
            $this->data['agents'] = getAgentsPrint($lawsuit_id);
            $this->data['respondents'] = getRespondentsPrint($lawsuit_id);
            $this->data['files'] = getFiles($lawsuit_id);
            $this->data['procedures'] = $this->get_procedures($lawsuit_id);
            $pdf = PDF::loadView(lawsuit_vw() . '.pdf', $this->data);
            // If you want to store the generated pdf to the server then you can use the store function
//        $pdf->save(storage_path().'_filename.pdf');
            //return $pdf->download('pdf.pdf');
//
//        return view(reports_vw() . '.pdf', $data);
//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
            return $pdf->stream();
        }
        return Redirect::back()->withErrors(['يرجى حفظ ملف الدعوى أولاً']);

    }

    public function get_procedures($lawsuit_id)
    {
        $prods = Procedure::where('file_id', '=', $lawsuit_id)->get();
        $html = '';
        $i = 0;
        foreach ($prods as $prod) {
            $html .= '<tr>';
            $html .= '<td>' . ++$i . '</td>';
            $html .= '<td>' . Carbon::parse($prod->prcd_date)->format('d/m/Y') . '</td>';
            $html .= '<td>' . $prod->prcd_text . '</td></tr>';

        }

        return $html;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        /* $lawsuit = Lawsuit::find($id);

         $lawsuit->court_id = $request->get('court_id');
         $lawsuit->judge = $request->get('judge');
         $lawsuit->lawsuit_type = $request->get('lawsuit_type');
         $lawsuit->suit_type = $request->get('suit_type');
         $lawsuit->lawsuit_value = $request->get('lawsuit_value');
         $lawsuit->file_status = $request->get('file_status');
         $lawsuit->court_file_no = $request->get('court_file_no');
         $lawsuit->appeal_file_no = $request->get('appeal_file_no');
         $lawsuit->veto_file_no = $request->get('veto_file_no');
         $lawsuit->executive_file_no = $request->get('executive_file_no');
         $lawsuit->police_file_no = $request->get('police_file_no');
         $lawsuit->noti_file_no = $request->get('noti_file_no');
         $lawsuit->close_date = $request->get('close_date');


l2         $lawsuit->save();
         return redirect()->to(lawsuit_vw() . '/Lawsuit');*/
    }

    public function lawsuitData(Request $request)
    {
        $file_no = $request->file_no;
        $police_file_no = $request->police_file_no;
        $court_file_no = $request->court_file_no;
        $appeal_file_no = $request->appeal_file_no;
        $veto_file_no = $request->veto_file_no;
        $executive_file_no = $request->executive_file_no;
        $prosecution_file_no = $request->prosecution_file_no;
        $complaint_no = $request->complaint_no;
        $noti_file_no = $request->noti_file_no;
        $lawsuit_type = $request->lawsuit_type;
        $file_status = $request->file_status;
        $name = $request->name;

        //dd(auth()->user()->emp_id);
        $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus']);
      /*  if ((auth()->user()->user_role != 1)) {//ليس محامي
            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus']);
            //  dd('ddddd');
        } else {//محامي
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();

            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus'])->whereIn('id', $files);
        }*/
        $lawsuit =$lawsuit->orderBy('id', 'desc');
        if (isset($file_no) && $file_no != null && $file_no != '') {
            $lawsuit = $lawsuit->where('file_no', $file_no);
        }
        if (isset($police_file_no) && $police_file_no != null && $police_file_no != '') {
            $lawsuit = $lawsuit->where('police_file_no', $police_file_no);
        }
        if (isset($court_file_no) && $court_file_no != null && $court_file_no != '') {
            $lawsuit = $lawsuit->where('court_file_no', $court_file_no);
        }
        if (isset($appeal_file_no) && $appeal_file_no != null && $appeal_file_no != '') {
            $lawsuit = $lawsuit->where('appeal_file_no', $appeal_file_no);
        }
        if (isset($veto_file_no) && $veto_file_no != null && $veto_file_no != '') {
            $lawsuit = $lawsuit->where('veto_file_no', $veto_file_no);
        }if (isset($executive_file_no) && $executive_file_no != null && $executive_file_no != '') {
        $lawsuit = $lawsuit->where('executive_file_no', $executive_file_no);
    }
        if (isset($prosecution_file_no) && $prosecution_file_no != null && $prosecution_file_no != '') {
            $lawsuit = $lawsuit->where('prosecution_file_no', $prosecution_file_no);
        }
        if (isset($complaint_no) && $complaint_no != null && $complaint_no != '') {
            $lawsuit = $lawsuit->where('complaint_no', $complaint_no);
        }
        if (isset($noti_file_no) && $noti_file_no != null && $noti_file_no != '') {
            $lawsuit = $lawsuit->where('noti_file_no', $noti_file_no);
        }
        if (isset($lawsuit_type) && $lawsuit_type != null && $lawsuit_type != 0) {
            $lawsuit = $lawsuit->where('lawsuit_type', $lawsuit_type);
        }
        if (isset($file_status)  && $file_status == 0) {

            $lawsuit = $lawsuit->where('file_status','!=', 4);
        }
        if (isset($file_status) && $file_status != null && $file_status != 0) {

            $lawsuit = $lawsuit->where('file_status', $file_status);
        }
        if (isset($name) && $name != null && $name != '') {

            $agent_list = Agent::where('name', 'like', '%' . $name . '%')->pluck('file_id')->toArray();
            //  dd($agent_list);
            // $sql = "lawyer_id  in ";
            $lawsuit = $lawsuit->whereIn('id', $agent_list);
        }
        $num = 1;
        return datatables()->of($lawsuit)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('lawsuit_file_no', function ($model) {// as foreach ($users as $user)
                //   dd($model->LawsuitReminder->file_no);
                if ($model->id !== null)
                    return '<a href="javascript:;" onclick="show_lawysuit(' . $model->id . ')" title="عرض ملف الدعوى">' . $model->file_no . '</a>';
                else
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
            ->filterColumn('agent_name', function ($query, $keyword) {
                $agent_list = Agent::where('name', 'like', '%' . $keyword . '%')->pluck('file_id')->toArray();
                // dd($emp_list);
                // $sql = "lawyer_id  in ";
                $query->whereIn('id', $agent_list);
            })
            ->filterColumn('lawsuit_file_no', function ($query, $keyword) {

                $query->where('file_no', 'like', '%' . $keyword . '%');
            })
            ->filterColumn('respondent_name', function ($query, $keyword) {
                $resp_list = Respondent::where('name', 'like', '%' . $keyword . '%')->pluck('file_id')->toArray();
                // dd($emp_list);
                // $sql = "lawyer_id  in ";
                $query->whereIn('id', $resp_list);
            })
            ->addColumn('open_date', function ($lawsuit) {// as foreach ($users as $user)
                if (isset($lawsuit->open_date))
                    return Carbon::parse($lawsuit->open_date)->format('d/m/Y');
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
            ->addColumn('file_status_desc', function ($lawsuit) {// as foreach ($users as $user)

                if (isset($lawsuit->fileStatus->desc))
                    return $lawsuit->fileStatus->desc;
                return '';
            })
            ->addColumn('future_session_date', function ($lawsuit) {// as foreach ($users as $user)

                if (isset($lawsuit->future_session_date))
                    //  return Carbon::parse($lawsuit->future_session_date)->format('Y-m-d');
                    return $lawsuit->future_session_date;
                return '';
            })->addColumn('last_procedure_date', function ($lawsuit) {// as foreach ($users as $user)

                if (isset($lawsuit->last_procedure_date))
                    //  return Carbon::parse($lawsuit->future_session_date)->format('Y-m-d');
                    return $lawsuit->last_procedure_date;
                return '';
            })
            ->addColumn('last_procedure_text', function ($lawsuit) {// as foreach ($users as $user)

                if (isset($lawsuit->last_procedure_text))
                    //  return Carbon::parse($lawsuit->future_session_date)->format('Y-m-d');
                    return $lawsuit->last_procedure_text;
                return '';
            })
            ->addColumn('action', function ($lawsuit) {// as foreach ($users as $user)
                $html = '';
                if (in_array(69, auth()->user()->user_per))
                    $html .= '<a class="btn btn-default btn-sm "  onclick="saveSession(' . $lawsuit->id . ',\'' . 'edit-lawsuit' . '\')" href="#"><i class="fa fa-print font-black"></i>  </a>';
                $html .= '<div class="btn-group"><button class="btn blue dropdown-toggle" type="button" data-toggle="dropdown"
aria-expanded="false"> تحكم<i class="fa fa-angle-down"></i></button><ul class="dropdown-menu" role="menu">';
                if (in_array(36, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'edit-lawsuit' . '\')" href="#"><i class="fa fa-edit font-red"></i> تعديل الملف </a></li>';
                if (in_array(39, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'procedure/create/' . '\')"  href="#"><i class="icon-docs font-red"></i> اضافة إجراء </a></li>';
                if (in_array(38, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'procedure/' . '\')" href="#"><i class="icon-tag font-red"></i> عرض الإجراءات </a></li>';
                if (in_array(39, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'session/create/' . '\')"  href="#"><i class="icon-docs font-red"></i> اضافة جلسة </a></li>';
                if (in_array(38, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'session/' . '\')" href="#"><i class="icon-tag font-red"></i> عرض الجلسات </a></li>';
                if (in_array(43, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'order/create/' . '\')"  href="#"><i class="fa fa-sticky-note font-red"></i> اضافة طلب</a></li>';

                if (in_array(42, auth()->user()->user_per))
                    $html .= '<li><a onclick="saveSession(' . $lawsuit->id . ',\'' . 'order/' . '\')"  href="#"><i class="fa fa-server font-red"></i> عرض الطلبات </a></li>';
                if (in_array(37, auth()->user()->user_per))
                    $html .= '<li><a onclick="deleteLawsuit('.$lawsuit->id.')"  href="#"><i class="fa fa-eraser font-red"></i> حذف الملف </a></li>';
                $html.='</ul></div>';
                return $html;
            })
            ->rawColumns(['action', 'lawsuitColor', 'lawsuit_file_no'])
            ->toJson();
    }

    public function storeAgent(Request $request)
    {
        // dd($request->all());
        if ($request->hdn_id == '') {
            $agent = new Agent();
            $agent->national_id = $request->national_id;
            $agent->name = $request->name;
            $agent->file_id = $request->hdn_file_no;
            $agent->mobile = $request->mobile;
            $agent->address = $request->address;
            $agent->email = $request->email;
            $agent->org_id = auth()->user()->org_id;
            $agent->justice_national_id = $request->justice_national_id;
            $agent->justice_name = $request->justice_name;
            $agent->created_by = auth()->user()->id;
        } else {
            $id = $request->hdn_id;
            $agent = Agent::find($id);
            $agent->national_id = $request->national_id;
            $agent->name = $request->name;
            //    $agent->file_id = $request->hdn_file_no;
            $agent->mobile = $request->mobile;
            $agent->address = $request->address;
            $agent->email = $request->email;
            //    $agent->org_id = auth()->user()->org_id;
            $agent->justice_national_id = $request->justice_national_id;
            $agent->justice_name = $request->justice_name;
            //   $agent->created_by = auth()->user()->id;

        }
        if ($agent->save()) {
            $agents = Agent::where('file_id', $request->hdn_file_no)->get();
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
                $html .= '<td><button type="button"  class="btn btn-icon-only green" onclick="updateAgent(' . $agent->id . ',\'' . $agent->national_id . '\',\'';
                $html .= $agent->name . '\',' . $agent->mobile . ',\'' . $agent->address . '\',\'' . $agent->email . '\',\'' . $agent->justice_national_id . '\',\'' . $agent->justice_name . '\')">';
                $html .= '<i class="fa fa-edit green-haze" ></i > </button >  ';
                $html .= '<button type="button"  class="btn btn-icon-only red" onclick="deleteAgent(' . $agent->id . ',this)"><i class="fa fa-minus red" ></i > </button > </td ></tr > ';

            }
            return response()->json(['success' => true, 'agent' => $html]);
        } else
            return response()->json(['success' => false]);


    }

    public function storeRespondent(Request $request)
    {
        // dd($request->all());
        if ($request->resp_hdn_id == '') {
            $resp = new Respondent();
            $resp->national_id = $request->resp_national_id;
            $resp->name = $request->resp_name;
            $resp->file_id = $request->hdn_file_no;
            $resp->mobile = $request->resp_mobile;
            $resp->address = $request->resp_address;
            $resp->org_id = auth()->user()->org_id;
            $resp->created_by = auth()->user()->id;
        } else {
            $id = $request->resp_hdn_id;
            $resp = Respondent::find($id);
            $resp->national_id = $request->resp_national_id;
            $resp->name = $request->resp_name;
            $resp->address = $request->resp_address;
            $resp->mobile = $request->resp_mobile;


        }
        if ($resp->save()) {
            $resps = Respondent::where('file_id', $request->hdn_file_no)->get();
            $html = '';
            foreach ($resps as $resp) {
                $html .= '<tr>';
                $html .= '<td>' . $resp->national_id . '</td>';
                $html .= '<td>' . $resp->name . '</td>';
                $html .= '<td>' . $resp->mobile . '</td>';
                $html .= '<td>' . $resp->address . '</td>';
                $html .= '<td><button type="button"  class="btn btn-icon-only green" onclick="updateResp(' . $resp->id . ',\'' . $resp->national_id . '\',\'' . $resp->name . '\',\'' . $resp->mobile . '\')">';
                $html .= '<i class="fa fa-edit green-haze" ></i > </button >  ';
                $html .= '<button type="button"  class="btn btn-icon-only red" onclick="deleteResp(' . $resp->id . ',this)"><i class="fa fa-minus red" ></i > </button > </td ></tr > ';

            }
            return response()->json(['success' => true, 'respondent' => $html]);
        } else
            return response()->json(['success' => false]);


    }

    public function deleteAgent(Request $request)
    {
        $id = $request->id;
        $agent = Agent::find($id);
        if ($agent)
            if ($agent->delete())
                return response()->json(['success' => true]);


    }

    public function deleteResp(Request $request)
    {
        $id = $request->id;
        $resp = Respondent::find($id);
        if ($resp)
            if ($resp->delete())
                return response()->json(['success' => true]);


    }

    public function setSession(Request $request)
    {
        $url = $request->url;
        //dd($url);
        session()->put('lawsuit_id', '');
        $id = $request->id;
        session()->put('lawsuit_id', $id);
        //  dd($id);
        return Redirect::to($url);


    }

    public function uploadFile(Request $request)
    {
        // dd($request->all());
        $fileUpload = new LawsuitUploadfile();
        $fileUpload->file_id = $request->hdn_file_no;
        $fileUpload->file_title = $request->file_title;

        if ($request->hasFile('file_name')) {

            $file = Input::file('file_name');
            $path = $this->storeFile($file, '/lawsuit_files/', false);
            $fileUpload->file_link = 'lawsuit_files/' . $path;

        }
        $fileUpload->created_by = auth()->user()->id;
        if ($fileUpload->save()) {
            $lawsuit_files = LawsuitUploadfile::where('file_id', $request->hdn_file_no)->get();
            $html = '';
            $i = 0;
            foreach ($lawsuit_files as $lawsuit_file) {
                $html .= '<tr><td>' . ++$i . '</td>';
                $html .= '<td><a href="' . url('/public/storage/' . $lawsuit_file->file_link) . '">' . $lawsuit_file->file_title . '</a></td>';
                $html .= '<td>' . $lawsuit_file->created_at . '</td>';

                $html .= '<td><button onclick="deleteFile(' . $lawsuit_file->id . ',this)" class="btn btn-warning"><i class="fa fa-minus"></i> </button> </td></tr>';
            }
            return response()->json(['success' => true, 'table' => $html]);
        }

    }

    function storeFile($file, $pathImg, $api = true)
    {

        $ext = $file->getClientOriginalExtension();
        $imgContent = File::get($file);


        $file_name = str_random(40) . time() . "." . $ext;
        $fullPath = public_path() . "/storage" . $pathImg . $file_name;

        $path = $file_name;
        File::put($fullPath, $imgContent);
        return $path;
    }

    public function deleteFile(Request $request)
    {
        $id = $request->id;
        $lawsuitFile = LawsuitUploadfile::find($id);
        if (isset($lawsuitFile)) {
            $lawsuitFile->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);


    }


    public function checkFileNo(Request $request)
    {
        $file_id = $request->file_id;//table id
        $file_no = $request->file_no;
        $court_id = $request->court_id;
        // dd($file_id);
        if ($file_id == '') {
            $lawsuit_count = Lawsuit::where('file_no', '=', $file_no)
                ->where('court_id', '=', $court_id)->count();
            //dd($lawsuit_count);
            if ($lawsuit_count > 0)
                return response()->json(['success' => true]);
            else
                return response()->json(['success' => false]);
        } else {
            $lawsuit_count = Lawsuit::where('file_no', '=', $file_no)
                ->where('id', '!=', $file_id)
                ->where('court_id', '=', $court_id)->count();

            // dd($lawsuit_count);
            if ($lawsuit_count > 0)
                return response()->json(['success' => true]);
            else
                return response()->json(['success' => false]);

        }
    }

    public function get_agents_by_id(Request $request)
    {
        // dd($request->all());
        $national_id = $request->national_id;
        $agents = Agent::where('org_id', auth()->user()->org_id)
            //->where('name','like','%'.$query.'%')
            ->where('national_id', '=', $national_id)
            ->first();
        if (isset($agents)) {

            // dd($data);
            return response()->json(['success' => true, 'data' => $agents]);
        }
        return response()->json(['success' => true, 'data' => '']);

    }

    public function get_agents_by_name(Request $request)
    {
        //dd($_GET['query']);
        $query = $_GET['query'];
        $agents = Agent::select('national_id', 'name', 'address', 'mobile', 'email')->distinct('name')->where('org_id', auth()->user()->org_id)
            ->where('name', 'like', '%' . $query . '%')
            // ->where('national_id','=',$id)
            ->get();
        if (count($agents) > 0) {
            foreach ($agents as $agent)
                $results[] = [
                    'national_id' => $agent->national_id,
                    'name' => $agent->name,
                    'mobile' => $agent->mobile,
                    'address' => $agent->address,
                    'email' => $agent->email];
            // dd($data);
            return response()->json($results);
        }
        return response()->json(['success' => true, 'value' => '']);

    }

    public function get_agents_by_name1(Request $request)
    {
        //dd($_GET['query']);
        $query = $_GET['query'];
        $agents = Agent::select('national_id', 'name', 'address', 'mobile', 'email')->distinct('name')->where('org_id', auth()->user()->org_id)
            ->where('name', 'like', '%' . $query . '%')
            // ->where('national_id','=',$id)
            ->get();
        if (count($agents) > 0) {
            foreach ($agents as $agent)
                $results[] = [
                    'national_id' => $agent->national_id,
                    'name' => $agent->name,
                    'mobile' => $agent->mobile,
                    'address' => $agent->address,
                    'email' => $agent->email];
            // dd($data);
            return response()->json($results);
        }
        return response()->json(['success' => true, 'value' => '']);

    }

    public function get_agents_names()
    {

        $agents = Agent::where('org_id', auth()->user()->org_id)
            ->get();
        if (count($agents) > 0) {
            foreach ($agents as $agent)
                $data[] = ['name' => $agent->name];
            // dd($data);
            return response()->json(['success' => true, 'result' => $data]);
        }
        return response()->json(['success' => true, 'result' => '']);
    }

    function del_one_lawsuit(Request $request)
    {
        $lawsuit_id = $request->id;


        $lawsuit = Lawsuit::find($lawsuit_id);

        if ($lawsuit) {
            $session=Session::where('file_id',$lawsuit_id)->delete();
            $responsible_lawyer=ResponsibleLawyer::where('file_id',$lawsuit_id)->delete();
            $respondent=Respondent::where('file_id',$lawsuit_id)->delete();
            $proceder=Procedure::where('file_id',$lawsuit_id)->delete();
            $reminder=Reminder::where('file_id',$lawsuit_id)->delete();
            $Order=Order::where('file_id',$lawsuit_id)->delete();
            $lawsuit_uploadfiles=LawsuitUploadfile::where('file_id',$lawsuit_id)->delete();
            $lawsuit_source=LawsuitSource::where('file_id',$lawsuit_id)->delete();
            $agent=Agent::where('file_id',$lawsuit_id)->delete();
            $lawsuit->delete();
            return response()->json(['success' => true]);
        }


    }

    function del_chk_lawsuit(Request $request)
    {
        //dd($request->all());

        /* $lawsuit_ids = $request->idArray;
         $session=Session::whereIn('file_id',$lawsuit_ids)->delete();
         $responsible_lawyer=ResponsibleLawyer::whereIn('file_id',$lawsuit_ids)->delete();
         $respondent=Respondent::whereIn('file_id',$lawsuit_ids)->delete();
         $proceder=Procedure::whereIn('file_id',$lawsuit_ids)->delete();
         $reminder=Reminder::whereIn('file_id',$lawsuit_ids)->delete();
         $Order=Order::whereIn('file_id',$lawsuit_ids)->delete();
         $lawsuit_uploadfiles=LawsuitUploadfile::whereIn('file_id',$lawsuit_ids)->delete();
         $lawsuit_source=LawsuitSource::whereIn('file_id',$lawsuit_ids)->delete();
         $agent=Agent::whereIn('file_id',$lawsuit_ids)->delete();
         $lawsuits = Lawsuit::whereIn('id', $lawsuit_ids)->delete();*/
        return response()->json(['success' => true]);
    }
}
