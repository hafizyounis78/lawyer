<?php

namespace App\Http\Controllers;

use App\Court;
use App\District;
use App\EvalRate;
use App\EvalSystem;
use App\FileLocation;
use App\FileStatus;
use App\Job;
use App\LawsuitType;
use App\Rate;
use App\UploadFileType;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        //  $this->data['page_title'] = 'اعدادات النظام';

        return view(setting_vw() . '.view')->with($this->data);

    }

    public function s1()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' انواع الملف القضائي';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s1')->with($this->data);
    }

    public function s2()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' انواع الملف ';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s2')->with($this->data);
    }

    public function s3()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' المحافظات';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s3')->with($this->data);
    }

    public function s4()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' المحاكم';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s4')->with($this->data);
    }

    public function s5()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' الوظائف';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s5')->with($this->data);
    }

    public function s6()
    {
        if (in_array(15, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'rating';
            $this->data['location_title'] = 'اعدادات النظام';
            $this->data['location_link'] = 'setting';
            $this->data['title'] = 'اعدادات النظام';
            $this->data['page_title'] = ' معاير التقييم';
            $this->data['portlet_title'] = 'اضافة قيمة';
            return view(setting_vw() . '.s6')->with($this->data);
        }
        return redirect()->back();
    }

    public function s7()
    {
        $this->data['sub_menu'] = 'rating';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = ' انظمة التقييم';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s7')->with($this->data);
    }

    public function s8()
    {
        if (in_array(16, auth()->user()->user_per)) {
        $this->data['sub_menu'] = 'rating';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = 'ادارة التقييمات';
        $this->data['portlet_title'] = 'اضافة قيمة';
        $this->data['rates'] = Rate::all();
        return view(setting_vw() . '.s8')->with($this->data);
        }
        return redirect()->back();
    }

    public function s9()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = 'حالات ملف الدعوة';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s9')->with($this->data);
    }
    public function s10()
    {
        $this->data['sub_menu'] = 'setting';
        $this->data['location_title'] = 'اعدادات النظام';
        $this->data['location_link'] = 'setting';
        $this->data['title'] = 'اعدادات النظام';
        $this->data['page_title'] = 'مكان الملف';
        $this->data['portlet_title'] = 'اضافة قيمة';
        return view(setting_vw() . '.s10')->with($this->data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function s1_data()
    {

        $table = LawsuitType::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\',\'' . $table->file_color . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function s2_data()
    {

        $table = UploadFileType::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function s2_data_old()
    {

        $table = UploadFileType::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-4">
                <div class="col-md-2">
                <a href="' . url('/setting/' . $table->id . '/edit') . '" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div>
                <div class="col-md-2">
                <form action="' . url('/setting/' . $table->id) . '" method="POST">
' . method_field('DELETE') . '

<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function s3_data()
    {

        $table = District::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function s4_data()
    {

        $table = Court::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function s5_data()
    {

        $table = Job::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }


    public function s7_data()
    {

        $table = EvalSystem::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function s8_data()
    {

        $table = EvalSystem::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                $html='<div class="col-md-6">';
                if (in_array(54, auth()->user()->user_per))
                    $html.= '<div class="col-md-2"><a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> </div>';
                if (in_array(55, auth()->user()->user_per))
                    $html.= '<div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div>';
                $html.='</div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function s9_data()
    {

        $table = FileStatus::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function s10_data()
    {

        $table = FileLocation::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)
                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" onclick="fillForm(' . $table->id . ',\'' . $table->desc . '\')" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div><div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="settingDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }
    public function s1_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new LawsuitType();
            $table->desc = $request->desc;
            $table->file_color = $request->file_color;
            $table->created_by = auth()->user()->id;

        } else {
            $table = LawsuitType::find($id);
            $table->desc = $request->desc;
            $table->file_color = $request->file_color;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }
    public function s2_save(Request $request)
    {
      //  dd($request->all());
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new UploadFileType();
            $table->desc = $request->desc;
            $table->created_by = auth()->user()->id;

        } else {
            $table = UploadFileType::find($id);
            $table->desc = $request->desc;
        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }
    public function s1_delete(Request $request)
    {

        $id = $request->id;
        $table = LawsuitType::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }
    public function s2_delete(Request $request)
    {

        $id = $request->id;
        $table = UploadFileType::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s3_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new District();
            $table->desc = $request->desc;

        } else {
            $table = District::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s3_delete(Request $request)
    {

        $id = $request->id;
        $table = District::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s4_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new Court();
            $table->desc = $request->desc;
            $table->created_by = auth()->user()->id;

        } else {
            $table = Court::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s4_delete(Request $request)
    {

        $id = $request->id;
        $table = Court::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s5_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new Job();
            $table->desc = $request->desc;
            $table->org_id = auth()->user()->org_id;


        } else {
            $table = Job::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s5_delete(Request $request)
    {

        $id = $request->id;
        $table = Job::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s6_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new Rate();
            $table->desc = $request->desc;
            $table->value = $request->txtvalue;
            $table->org_id = auth()->user()->org_id;
            $table->created_by = auth()->user()->id;

        } else {
            $table = Rate::find($id);
            $table->desc = $request->desc;
            $table->value = $request->txtvalue;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s6_delete(Request $request)
    {

        $id = $request->id;
        $table = Rate::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s7_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new EvalSystem();
            $table->desc = $request->desc;
            $table->org_id = auth()->user()->org_id;
            $table->created_by = auth()->user()->id;

        } else {
            $table = EvalSystem::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public function s7_delete(Request $request)
    {

        $id = $request->id;
        $table = EvalSystem::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public function s8_save(Request $request)
    {
        //  dd($request->all());
        $id = $request->hdn_table_id;
        $rate = $request->rate;
        //  dd($rate);
        if ($id == '') {
            $table = new EvalSystem();
            $table->desc = $request->desc;
            $table->org_id = auth()->user()->org_id;
            $table->created_by = auth()->user()->id;
            if ($table->save()) {

                for ($i = 0; $i < count($rate); ++$i) {

                    $table2 = new EvalRate();
                    $table2->eval_id = $table->id;
                    $table2->rate_id = $rate[$i];
                    $table2->org_id = auth()->user()->org_id;
                    $table2->created_by = auth()->user()->id;
                    $table2->save();
                }
                return response()->json(['success' => true, 'id' => $table->id]);//return redirect()->to(role_vw() . '/');//
            } else
                return response()->json(['success' => false]);
        } else {
            $table = EvalSystem::find($id);
            $table->desc = $request->desc;

            if ($table->save()) {
                for ($i = 0; $i < count($rate); ++$i) {
                    $onlySoftDeleted = EvalRate::onlyTrashed()->where('eval_id', $id)->where('rate_id', $rate[$i])->count();
                    if ($onlySoftDeleted > 0) {
                        $deletedrow = EvalRate::onlyTrashed()->where('eval_id', $id)->where('rate_id', $rate[$i])->first();
                        $deletedrow->deleted_at = null;
                        $deletedrow->save();
                    } else {


                        $evalRates = EvalRate::where('eval_id', $id)->where('rate_id', $rate[$i])->count();
                        if ($evalRates == 0) {
                            $table2 = new EvalRate();
                            $table2->eval_id = $id;
                            $table2->rate_id = $rate[$i];
                            $table2->org_id = auth()->user()->org_id;
                            $table2->created_by = auth()->user()->id;
                            $table2->save();
                        }
                    }
                }
            } else
                return response()->json(['success' => false]);
            //  }
        }


    }

    public
    function s8_delete(Request $request)
    {

        $id = $request->id;
        $table = EvalSystem::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }

    public
    function s9_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new FileStatus();
            $table->desc = $request->desc;
            $table->created_by = auth()->user()->id;

        } else {
            $table = FileStatus::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public
    function s9_delete(Request $request)
    {

        $id = $request->id;
        $table = FileStatus::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

    }
    public
    function s10_save(Request $request)
    {
        $id = $request->hdn_table_id;
        if ($id == '') {
            $table = new FileLocation();
            $table->desc = $request->desc;
            $table->created_by = auth()->user()->id;

        } else {
            $table = FileLocation::find($id);
            $table->desc = $request->desc;

        }
        if ($table->save()) {
            return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

        } else
            return response()->json(['success' => false]);

    }

    public
    function s10_delete(Request $request)
    {

        $id = $request->id;
        $table = FileLocation::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);

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
