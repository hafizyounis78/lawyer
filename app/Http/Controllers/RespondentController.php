<?php

namespace App\Http\Controllers;

use App\Respondent;
use Illuminate\Http\Request;

class RespondentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(71, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'report';
            $this->data['location_title'] = 'التقارير';
            $this->data['location_link'] = 'agent-report';
            $this->data['title'] = 'التقارير';
            $this->data['page_title'] = 'تقرير الخصوم';
            return view(reports_vw() . '.respondent')->with($this->data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function RespondentReport(Request $request)

    {
        // dd($date);

        $model =  Respondent::select('national_id', 'name', 'address', 'mobile')->distinct('name')->where('org_id', auth()->user()->org_id);

        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })

            ->toJson();
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
        //
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
    public function destroy($id)
    {
        //
    }
}
