<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Job;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function logout()
    {

        auth()->logout();
        return redirect()->back();
    }

    public function login()
    {

        return redirect()->to('login');
    }

    public function index()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض المستخدمين';
        $this->data['location_link'] = 'user';
        $this->data['title'] = 'المستخدمين';
        $this->data['page_title'] = 'عرض المستخدمين';
        return view(user_vw() . '.view')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض المستخدمين';
        $this->data['location_link'] = 'user';
        $this->data['title'] = 'المستخدمين';
        $this->data['page_title'] = 'اضافة مستخدم جديد ';
        $this->data['emp'] = getLookupEmployees();
        $this->data['roles'] = Role::all();
        return view(user_vw() . '.create')->with($this->data);
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
        $user = New User();
        $user->email = $request->get('email');
        $user->emp_id = $request->get('emp_id');
        $user->isActive = 1;
        $user->user_role = $request->get('role');
        $user->org_id = auth()->user()->org_id;
        if ($request->has('password'))
            $user->password = bcrypt($request->get('password'));


        if ($user->save())
            return response()->json(['success' => true]);
        else
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

    public function availabileEmail(Request $request)
    {
        $email = $request->email;
        $count = User::where('email', '=', $email)
            ->where('org_id', '=', auth()->user()->org_id)
            ->count();
        if ($count >= 1)
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض المستخدمين';
        $this->data['location_link'] = 'user';
        $this->data['title'] = 'المستخدمين';
        $this->data['page_title'] = 'تعديل بيانات مستخدم  ';
        $this->data['one_user'] = User::where('emp_id', '=', $id)->first();
        //  dd($this->data['one_user']);
        $this->data['emp'] = Employee::find($id);
        $this->data['jobs'] = getLookupJobs();
        $this->data['districts'] = getLookupDistricts();
        $this->data['roles'] = Role::all();
        //dd($user);
        return view(user_vw() . '.edit')->with($this->data);
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
        //dd($request->all());
        $user = User::find($id);

        $user->email = $request->get('email');
        if ($request->has('password'))
            if ($user->password != $request->get('password')) {
                //  dd('yes');
                $user->password = bcrypt($request->get('password'));
            }
        $user->user_role = $request->get('role');
        $user->save();
        if ($user->save())
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function userData()
    {
        $model = User::with('userEmployee');

        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('name', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->name))
                    return $model->userEmployee->name;
                return '';
            })
            ->addColumn('national_id', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->national_id))
                    return $model->userEmployee->national_id;
                return '';
            })
            ->addColumn('job_title', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->job_desc))
                    return $model->userEmployee->job_desc;
                return '';
            })
            ->addColumn('district', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->district_desc))
                    return $model->userEmployee->district_desc;
                return '';
            })
            ->addColumn('address', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->address))
                    return $model->userEmployee->address;
                return '';
            })
            ->addColumn('mobile', function ($model) {// as foreach ($users as $user)
                if (isset($model->userEmployee->mobile))
                    return $model->userEmployee->mobile;
                return '';
            })->addColumn('active', function ($model) {


                $i = 1;
                $html = '<div class="col-md-10">';
                if ($model->isActive == 1) {
                    $html.= '<div class="col-md-5" ><i style="font-size: 25px !important;" id="i' . $model->id . '" class="fa fa-user font-green" 
							onclick="updateUserstatus(\'' . $model->id . '\')" style="cursor:pointer"></i></div>';

                } else {
                    $html.= '<div class="col-md-5" ><i style="font-size: 25px !important;" id="i' . $model->id . '" class="fa fa-user font-red-sunglo" 
							onclick="updateUserstatus(\'' . $model->id . '\')" style="cursor:pointer"></i></div>';

                }

                $html .= '</div>';
                return $html;

            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                $html = '<div class="col-md-12">';
                $i = 1;
               /* if ($table->isActive == 1) {
                    $html.= '<div class="col-md-5" ><i style="font-size: 25px !important;" id="i' . $table->id . '" class="fa fa-user font-green" 
							onclick="updateUserstatus(\'' . $table->id . '\')" style="cursor:pointer"></i></div>';

                } else {
                    $html.= '<div class="col-md-5" ><i style="font-size: 25px !important;" id="i' . $table->id . '" class="fa fa-user font-red-sunglo" 
							onclick="updateUserstatus(\'' . $table->id . '\')" style="cursor:pointer"></i></div>';

                }*/
                $html .= '<div class="col-md-6"><a href="' . url('/user/' . $table->emp_id . '/edit') . '" type="button" class=" btn btn-icon-only yellow"><i class="fa fa-edit"></i></a> 
                </div>';
                $html .= '<div class="col-md-6" ><button type = "button" class="btn btn-icon-only red" onclick = "deleteUser(' . $table->id . ')" ><i class="fa fa-times" ></i ></button ></div >';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action', 'active'])
            ->toJson();
    }

    /* public function destroy($id)
     {
         $user = User::find($id);
         if (isset($user))
             $user->delete();
         return redirect()->back();
     }*/

    public function getEmployee(Request $request)
    {
        $emp_id = $request->id;
        $emp = Employee::find($emp_id);
        return response()->json(['success' => true, 'data' => $emp]);

    }

    public function activateUser(Request $request)
    {

        $id = $request->id;
        $isActive = $request->isactive;
        $user = User::find($id);
        if (isset($user)) {
            $user->isActive = $isActive;
            $user->save();
        }
        return response()->json(['success' => true, 'user' => $user]);
    }

    public function deleteUser(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        if (isset($user))
            $user->delete();
        return redirect()->back();
    }
    function clear()
    {

        //  Artisan::call('cache:clear');
        // Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('route:cache');
        Artisan::call('view:clear');


        return "Cleared!";

    }
}
