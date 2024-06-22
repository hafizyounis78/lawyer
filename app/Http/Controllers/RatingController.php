<?php

namespace App\Http\Controllers;

use App\EmpEval;
use App\EmpEvalDetail;
use App\EmpEvalMaster;
use App\Employee;
use App\EvalRate;
use App\EvalSystem;
use App\Rate;
use App\User;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(17, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'rating';
            $this->data['location_title'] = 'عرض تقييم الموظفين';
            $this->data['location_link'] = 'rating';
            $this->data['title'] = 'التقييم';
            $this->data['page_title'] = 'عرض التقييم';
            return view(rating_vw() . '.view')->with($this->data);
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
        if (in_array(56, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'rating';
            $this->data['location_title'] = 'عرض تقييم الموظفين';
            $this->data['location_link'] = 'rating';
            $this->data['title'] = 'التقييم';
            $this->data['page_title'] = ' اضافة التقييم';
            $this->data['emp'] = Employee::where('org_id', auth()->user()->org_id)->get();//User::with('userEmployee')->get();
            $this->data['evalSystems'] = EvalSystem::all();
            return view(rating_vw() . '.create')->with($this->data);
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
        //
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

        $this->data['sub_menu'] = 'rating';
        $this->data['location_title'] = 'عرض تقييم الموظفين';
        $this->data['location_link'] = 'rating';
        $this->data['title'] = 'التقييم';
        $this->data['page_title'] = 'تعديل التقييم';
        $evalMaster = EmpEvalMaster::find($id);
        $this->data['emp'] = Employee::find($evalMaster->emp_id);//User::with('userEmployee')->get();

        $this->data['evalMaster'] = $evalMaster;
        $this->data['eval_table'] = $this->getEmpEval($evalMaster->eval_system_id, $id);
        return view(rating_vw() . '.edit')->with($this->data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function getEmpEval($id, $master_id)
    {
        //$eval_rates = EmpEvalDetail::with('evalRate')->where('eval_master_id', $id)
        //   $eval_rates = EmpEvalDetail::Leftjoin('eval_rates', 'eval_rates.id', '=','eval_rate_id')
        $details = EvalRate::Leftjoin('emp_eval_details', 'eval_rates.id', '=', 'emp_eval_details.eval_rate_id')
            ->where('eval_master_id', $master_id)
            ->where('eval_id', $id)
            ->get();
        /*$eval_rates = EvalRate::whereIn('')

        Leftjoin('emp_eval_details', 'eval_rates.id', '=','emp_eval_details.eval_rate_id')
            ->where('eval_master_id', $master_id)
            ->where('eval_id', $id)

            ->get();*/
        $html = '';
        $i = 0;
        foreach ($details as $eval_rate) {
            $html .= "<tr><td>" . ++$i . "</td>";
            $html .= "<td>" . $eval_rate->rate_desc . " </td > ";
            $html .= "<td > " . $eval_rate->rate_value . "</td > ";
            $html .= "<td ><input type = 'text' id = 'eval_rate_id' data-value ='" . $eval_rate->rate_value . "' data-hdn-id = '" . $eval_rate->id . "' name = 'eval_rate_id' 
value ='" . $eval_rate->value . "' data-id = '" . $eval_rate->id . "'  onchange = 'saveEmpRate(this);' ></td ></tr > ";
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

    public function s6_data()
    {

        $table = Rate::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                $html = '<div class="col-md-6">';
                if (in_array(51, auth()->user()->user_per))
                    $html .= '<div class="col-md-3"><a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\',\'' . $table->value . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
            </div >';
                if (in_array(52, auth()->user()->user_per))
                    $html .= '<div class="col-md-3" ><button type = "button" class="btn btn-icon-only red" 
onclick = "settingDelete(' . $table->id . ')" ><i class="fa fa-times" ></i ></button ></div >';
                $html .= '</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function ratingData()
    {
        $table = EmpEvalMaster::with('evalDetails', 'Employee')->get();

        // ->having('eval_confirm',0);
//dd($table[0]->Employee);
        $num = 1;
        //rate_system
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })->addColumn('emp_name', function ($table) {// as foreach ($users as $user)
                if (isset($table->Employee->name))
                    return $table->Employee->name;
                return '';
            })
            ->addColumn('emp_national_id', function ($table) {// as foreach ($users as $user)
                if (isset($table->Employee->national_id))
                    return $table->Employee->national_id;
                return '';
            })
            ->addColumn('system_name', function ($table) {// as foreach ($users as $user)

                return $table->system_desc;
            })
            ->addColumn('eval_result', function ($table) {// as foreach ($users as $user)

                return $table->eval_result;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                if ($table->eval_status != 1) {

                    $html = '<div class="col-md-12">';
                    if (in_array(57, auth()->user()->user_per))
                        $html .= '<div class="col-md-4" ><a id = "btn_edit_' . $table->id . '" href = "' . url('/rating/' . $table->id . '/edit') . '" type = "button" 
                class=" btn btn-icon-only green" ><i class="fa fa-edit" ></i ></a > 
                </div >';
                    if (in_array(59, auth()->user()->user_per))
                        $html .= '<div class="col-md-4" >
                <button id = "btn_confirm_' . $table->id . '" class=" btn btn-icon-only yellow" title = "إعتماد التقييم" onclick = "eval_confirm(' . $table->id . ')" ><i class="icon-diamond" ></i ></button > 
                </div >';
                    if (in_array(58, auth()->user()->user_per))
                        $html .= '<div class="col-md-4" ><button onclick = "deleteEval(' . $table->id . ')" id = "btn_delete_' . $table->id . '" type = "submit" class="btn btn-icon-only red" ><i class="fa fa-times" ></i ></button ></div >';
                    $html .= '</div>';
                    return $html;
                } else
                    $html = '<span class="label label-sm label-success" > معتمد </span > ';

                return $html;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function getEvalsystemRates(Request $request)
    {
        $id = $request->id;

        $rates = Rate::all();
        $eval_rates = EvalRate::where('eval_id', $id)->get();
        //  dd($eval_rates);
        $html = '';

        $selected = '';

        foreach ($rates as $rate) {
            //  dd($role_per->permissions);
            $selected = "";
            foreach ($eval_rates as $eval_rate) {

                if ($eval_rate->rate_id == $rate->id) {

                    $selected = 'selected';

                }


            }
            $html .= ' <option value = "' . $rate->id . '" ' . $selected . ' > ' . $rate->desc . '</option > ';
        }

        foreach ($eval_rates as $eval_rate) {
            $selected = 'selected';
            $found = '';
            foreach ($rates as $rate) {
                if ($eval_rate->rate_id == $rate->id)
                    $found = true;
            }
            if (!$found)
                $html .= ' <option value = "' . $rate->id . '" ' . $selected . ' > ' . $rate->desc . '</option > ';

        }


        return response()->json(['success' => true, 'rate' => $html]);

    }

    public function deselectRate(Request $request)
    {
        $id = $request->id;
        $rate_id = $request->values[0];

        $perRole = EvalRate::where('rate_id', $rate_id)
            ->where('eval_id', $id)->delete();

        return response()->json(['success' => true]);
    }

    public function getSystemRate(Request $request)
    {
        $id = $request->id;
        $emp_id = $request->emp_id;
        // dd($id);
        if ($emp_id == '')
            $eval_rates = EvalRate::with('Rates')->where('eval_id', $id)->get();
        else
            $eval_rates = EvalRate::with('Rates')->where('eval_id', $id)
                //  ->Leftjoin('emp_evals', 'emp_evals . eval_rate_id', 'eval_rates . id')
                //->where('emp_id', $emp_id)
                //  ->where('eval_confirm',0)
                ->get();
        $html = '';
        $i = 0;
        foreach ($eval_rates as $eval_rate) {
            $html .= ' <tr>
<td > ' . ++$i . '</td >
<td > ' . $eval_rate->Rates->desc . '</td >
<td > ' . $eval_rate->Rates->value . '</td >
<td ><input type = "text" id = "eval_rate_id" data-hdn-id = "" data-value ="' . $eval_rate->rate_value . '" name = "eval_rate_id" value = "' . $eval_rate->value . '" data-id = "' . $eval_rate->id . '" onchange = "saveEmpRate(this);" ></td >
</tr > ';
        }
        //   dd($html);
        return response()->json(['success' => true, 'table' => $html]);

    }

    public function saveEmpRate(Request $request)
    {
        /*$empRate->eval_rate_id = $request->rate_id;
        $empRate->value = $request->rate_value;*/
        $hdn_id = $request->hdn_id;
        $master_id = $request->master_id;
        if ($hdn_id == '') {
            if ($master_id == '') {
                $empRateMaster = new  EmpEvalMaster();
                $empRateMaster->eval_system_id = $request->eval_id;
                $empRateMaster->emp_id = $request->emp_id;
                $empRateMaster->eval_date = date('Y-m-d');
                $empRateMaster->eval_status = 2;
                $empRateMaster->org_id = auth()->user()->org_id;
                $empRateMaster->created_by = auth()->user()->id;
                $empRateMaster->save();
            }
            if ($master_id == '')
                $master_id = $empRateMaster->id;
            $empRateDetials = new EmpEvalDetail();
            $empRateDetials->eval_master_id = $master_id;
            $empRateDetials->eval_rate_id = $request->rate_id;
            $empRateDetials->value = $request->rate_value;
            $empRateDetials->created_by = auth()->user()->id;
            if ($empRateDetials->save())
                return response()->json(['success' => true, 'master_id' => $master_id, 'detail_id' => $empRateDetials->id]);


        } else {
            $empRateDetials = EmpEvalDetail::find($hdn_id);
            $empRateDetials->value = $request->rate_value;
            if ($empRateDetials->save())
                return response()->json(['success' => true, 'master_id' => $master_id, 'detail_id' => $empRateDetials->id]);
        }

    }

    public function confirmRate(Request $request)
    {
        $id = $request->id;
        $eval = EmpEvalMaster::find($id);
        $eval->eval_status = 1;
        if ($eval->save())
            return response()->json(['success' => true]);

    }

    public function deleteRate(Request $request)
    {
        $id = $request->id;
        $eval = EmpEvalMaster::find($id);
        if (isset($eval))
            $eval->delete();
        return response()->json(['success' => true]);

    }

    public function destroy($id)
    {
        dd('delete');
    }
}
