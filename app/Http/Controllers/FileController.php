<?php

namespace App\Http\Controllers;

use App\FileLocation;
use App\FileUpload;
use App\UploadFileType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;

class FileController extends Controller
{
    public function index()
    {
        if (in_array(35, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'file';
            $this->data['location_title'] = 'عرض ارشيف الملفات';
            $this->data['location_link'] = 'file';
            $this->data['title'] = 'ارشيف الملفات ';
            $this->data['FileTypes'] = UploadFileType::get();
            $this->data['FileLocations'] = FileLocation::get();
            $this->data['page_title'] = 'عرض الملفات';
            return view(file_vw() . '.view')->with($this->data);
        }
        return redirect()->back();

    }

    public function filesData()

    {
        $model = FileUpload::all();
        /*join('employees', 'emp_id', '=', 'lawyer_id')
            ->join('task_statuses', 'task_statuses.id', '=', 'task_status');*/
        $num = 1;
        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('fileLinks', function ($model) {// as foreach ($users as $user)

                return '<a href="' . url('/public/storage/' . $model->file_link) . '">' . $model->file_title . '</a>';
            })
            ->editColumn('file_desc', function ($model) {// as foreach ($users as $user)
                 return $model->type_desc;
             })->editColumn('file_share_desc', function ($model) {// as foreach ($users as $user)
                $share=['0'=>'لا','1'=>'نعم'];
                 return $share[$model->file_share];
             })
            ->editColumn('file_loc', function ($model) {// as foreach ($users as $user)
                return $model->file_loc;
            })
            ->addColumn('action', function ($model) {// as foreach ($users as $user)

                return '<button onclick="deleteFile(' . $model->id . ',this)" class="btn btn-warning"><i class="fa fa-minus"></i> </button> ';
            })
            ->rawColumns(['fileLinks','file_share_desc' ,'action'])
            ->toJson();
    }

    public function uploadFile(Request $request)
    {
       // dd($request->all());
        $fileUpload = new FileUpload();
        $fileUpload->file_title = $request->file_title;
        $fileUpload->file_note = $request->file_note;
        $fileUpload->file_location = $request->file_location;
        $fileUpload->file_type = $request->file_type;
        $fileUpload->file_share = (isset($request->file_share)?$request->file_share:0);

        if ($request->hasFile('file_name')) {

            $file = Input::file('file_name');
            $path = $this->storeFile($file, '/general_files/', false);
            $fileUpload->file_link = 'general_files/' . $path;

        }
        $fileUpload->created_by = auth()->user()->id;
        if ($fileUpload->save()) {
            $files = FileUpload::all();
            $html = '';
            $i = 0;
            $share=['0'=>'لا','1'=>'نعم'];
            foreach ($files as $file) {
                $html .= '<tr><td>' . ++$i . '</td>';
                $html .= '<td><a href="' . url('/public/storage/' . $file->file_link) . '">' . $file->file_title . '</a></td>';
                $html .= '<td>' . $file->type_desc . '</td>';
                $html .= '<td>' . $file->file_loc . '</td>';
                $html .= '<td>' . $file->file_note . '</td>';
                $html .= '<td>' . $share[$file->file_share] . '</td>';
                $html .= '<td><button onclick="deleteFile(' . $file->id . ',this)" class="btn btn-warning"><i class="fa fa-minus"></i> </button> </td></tr>';
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
        $file = FileUpload::find($id);
        if (isset($file)) {
            $file->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);


    }
}
