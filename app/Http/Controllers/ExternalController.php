<?php

namespace App\Http\Controllers;

use App\ExternalEmployee;
use Illuminate\Http\Request;

class ExternalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'إعدادت النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = ' إعدادت النظام';
        $this->data['page_title'] = 'اضافة وتعديل المصادر الخارجية';
        $this->data['table_title'] = 'عرض المصادر الخارجية';
        return view(externalemp_vw() . '.create')->with($this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $id = $request->get('id');
        if ($id == null || $id == '' ) {


            $emp = New ExternalEmployee();
            $emp->national_id = $request->get('national_id');
            $emp->name = $request->get('name');
            $emp->email = $request->get('email');
            $emp->mobile = $request->get('mobile');
            $emp->org_id = auth()->user()->org_id;
        } else {

            $emp = ExternalEmployee::find($id);

            $emp->name = $request->get('name');
            $emp->national_id = $request->get('national_id');
            $emp->email = $request->get('email');
            $emp->mobile = $request->get('mobile');
            $emp->org_id = auth()->user()->org_id;
        }
        if ($emp->save())
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);
        //return redirect()->to(employee_vw() . '/employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function empData()
    {
        //   return Datatables::eloquent(User::query())->toJson();
        //
        $emp =ExternalEmployee::get();

        $num = 1;
        return datatables()->of($emp)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-10">
                <div class="col-md-5">
                <button href="#" id="editbtn" name="editbtn" onclick="edit_row('.$table->id.',\''.$table->name.'\',\''.$table->email.'\','.$table->national_id.','.$table->mobile.')"  type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></button> 
                </div>
                <div class="col-md-5">
                <form action="' . url('/externalemp/' . $table->id) . '" method="POST">
' . method_field('DELETE') . '

<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div></div>';
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
        $count = ExternalEmployee::where('email', '=', $email)
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
        $count = ExternalEmployee::where('national_id', '=', $id)
            ->where('org_id', '=', auth()->user()->org_id)
            ->count();
        if ($count >= 1)
            return response()->json(['success' => true]);
        else
            return response()->json(['success' => false]);
    }

    public function destroy($id)
    {
        $emp = ExternalEmployee::find($id);
        if ($emp)

            if ($emp->delete())
                return redirect()->to(externalemp_vw() . '/');

    }
}
