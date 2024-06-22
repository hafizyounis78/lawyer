<?php

namespace App\Http\Controllers;

use App\District;
use App\Employee;
use App\EmployeeUploadFile;
use App\Job;
use App\ResponsibleLawyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(12, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'employee';
            $this->data['location_title'] = 'عرض الموظفين';
            $this->data['location_link'] = 'employee';
            $this->data['title'] = 'الموظفين';
            $this->data['page_title'] = 'عرض الموظفين';
            return view(employee_vw() . '.view')->with($this->data);
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
        if (in_array(13, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'employee';
            $this->data['location_title'] = 'عرض الموظفين';
            $this->data['location_link'] = 'employee';
            $this->data['title'] = 'الموظفين';
            $this->data['page_title'] = 'اضافة موظف';
            $this->data['jobs'] = getLookupJobs();
            $this->data['districts'] = getLookupDistricts();

            return view(employee_vw() . '.create')->with($this->data);
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
        // dd($request->all());
        $emp = New employee();
        $emp->name = $request->get('name');
        $emp->national_id = $request->get('national_id');
        $emp->address = $request->get('address');
        $emp->email = $request->get('email');
        $emp->start_date = $request->get('start_date');
        $emp->end_date = $request->get('end_date');
        $emp->mobile = $request->get('mobile');
        $emp->districts_id = $request->get('districts_id');
        $emp->job_title = $request->get('job_title');
        $emp->org_id = auth()->user()->org_id;

        if ($emp->save())

            return response()->json(['success' => true, 'emp_id' => $emp->emp_id]);
        else
            return response()->json(['success' => false]);
        //return redirect()->to(employee_vw() . '/employee');
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
        $this->data['sub_menu'] = 'employee';
        $this->data['location_title'] = 'عرض الموظفين';
        $this->data['location_link'] = 'employee';
        $this->data['title'] = 'الموظفين';
        $this->data['page_title'] = 'تعديل موظف';
        $this->data['emp'] = Employee::find($id);
        $this->data['jobs'] = Job::all();
        $this->data['districts'] = District::all();
        $this->data['files'] = $this->getEmpFiles($id);
        //dd($user);
        return view(employee_vw() . '.edit')->with($this->data);
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

        $emp = Employee::find($id);

        $emp->name = $request->get('name');
        $emp->national_id = $request->get('national_id');
        $emp->address = $request->get('address');
        $emp->email = $request->get('email');
        $emp->start_date = $request->get('start_date');
        $emp->end_date = $request->get('end_date');
        $emp->mobile = $request->get('mobile');
        $emp->districts_id = $request->get('districts_id');
        $emp->job_title = $request->get('job_title');


        if ($emp->save()) {
            //dd('update');
            return response()->json(['success' => true]);
        } else
            return response()->json(['success' => false]);


        return redirect()->to(employee_vw() . '/employee');
    }

    public function empData()
    {
        //   return Datatables::eloquent(User::query())->toJson();
        //
        $emp = Employee::get();
        $num = 1;
        return datatables()->of($emp)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('title', function ($model) {// as foreach ($users as $user)

                return $model->job_desc;
            })
            ->addColumn('district', function ($model) {// as foreach ($users as $user)

                return $model->district_desc;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                $html = '<div class="col-md-10">';
                if (in_array(48, auth()->user()->user_per))
                    $html .= '<div class="col-md-5"><a  href="' . url('/employee/' . $table->emp_id . '/edit') . '" class="btn btn-icon-only green"><i class="fa fa-edit"></i></a></div>';
                if (in_array(49, auth()->user()->user_per))
                    $html .= '<div class="col-md-3" ><button type = "button" class="btn btn-icon-only red" 
onclick = "deleteEmp(' . $table->emp_id . ')" ><i class="fa fa-times" ></i ></button ></div >';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function availabileEmail(Request $request)
    {
        $email = $request->email;
        $count = Employee::where('email', '=', $email)
            ->where('org_id', '=', auth()->user()->org_id)
            ->count();
        if ($count >= 1)
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);

    }

    public function availabileNationalId(Request $request)
    {
        $id = $request->id;
        $count = Employee::where('national_id', '=', $id)
            ->where('org_id', '=', auth()->user()->org_id)
            ->count();
        if ($count >= 1)
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);
    }

    public function uploadFile(Request $request)
    {
      // dd($request->all());
        if (isset($request->hdn_emp_id) && $request->hdn_emp_id!='') {
            $fileUpload = new EmployeeUploadFile();
            $fileUpload->emp_id = $request->hdn_emp_id;
            $fileUpload->file_title = $request->file_title;

            if ($request->hasFile('file_name')) {

                $file = Input::file('file_name');
                $path = $this->storeFile($file, '/employees/', false);
                $fileUpload->file_link = '/employees/' . $path;

            }

            $fileUpload->created_by = auth()->user()->id;
            if ($fileUpload->save()) {
             //   dd($fileUpload);
                $emp_files = EmployeeUploadFile::where('emp_id', $request->hdn_emp_id)->get();
                $html = '';
                $i = 0;
                foreach ($emp_files as $emp_file) {
                    $html .= '<tr><td>' . ++$i . '</td>';
                    $html .= '<td><a href="' . url('/public/storage/' . $emp_file->file_link) . '">' . $emp_file->file_title . '</a></td>';
                    $html .= '<td>' . $emp_file->created_at->format('d/m/Y') . '</td>';
                    $html .= '<td><button onclick="deleteFile(' . $emp_file->id . ',this)" class="btn btn-warning"><i class="fa fa-minus"></i> </button> </td></tr>';
                }
                return response()->json(['success' => true, 'table' => $html]);
            }
        }
        return Redirect::back()->withErrors(['يرجى حفظ بيانات الموظف أولاً']);

    }

    /*public function destroy($id)
    {
        $emp = Employee::find($id);
        if ($emp)

            if ($emp->delete())
                return redirect()->to(employee_vw() . '/');

    }*/

    public function deleteFile(Request $request)
    {
        $id = $request->id;
        $lawsuitFile = EmployeeUploadFile::find($id);
        if (isset($lawsuitFile)) {
            $lawsuitFile->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);


    }
    function getEmpFiles($id)
    {
        $resps = EmployeeUploadFile::where('emp_id', $id)->get();
        $html = '';
        $i = 0;
        foreach ($resps as $resp) {

            $html .= '<tr><td>' . ++$i . '</td>';
            $html .= '<td><a href="' . url('/public/storage/' . $resp->file_link) . '">' . $resp->file_title . '</a></td>';
            $html .= '<td>' . $resp->created_at->format('d/m/Y') . '</td>';

            $html .= '<td><button onclick="deleteFile(' . $resp->id . ',this)" class="btn btn-warning"><i class="fa fa-minus"></i> </button> </td></tr>';
        }
        return $html;
    }
    public function deleteEmp(Request $request)
    {
        $id=$request->id;
        $emp = Employee::find($id);
        if ($emp)

            if ($emp->delete())
                return redirect()->to(employee_vw() . '/');

    }
}
