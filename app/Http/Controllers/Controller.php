<?php

namespace App\Http\Controllers;

use App\Lawsuit;
use App\ResponsibleLawyer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getFilesCount($status, $start = null, $end = null)
    {
        //if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
        if ((auth()->user()->user_role !=1)){// || auth()->user()->user_role == 2)) {
            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus'])
                ->where('file_status', '=', $status);
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->count();

        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();
            $lawsuit = Lawsuit::with(['lawsuitType', 'fileStatus'])
                ->whereIn('id', $files)
                ->where('file_status', '=', $status);
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->count();
        }

        return $lawsuit;

    }
    public function getResultCount($type, $start = null, $end = null)
    {
        if ((auth()->user()->user_role !=1)){// || auth()->user()->user_role == 2)) {
       // if ((auth()->user()->user_role == 3 || auth()->user()->user_role == 5)) {
            $lawsuit = Lawsuit::where('lawsuit_result', '=', $type);
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->count();
        } else {
            $lawyer_id = auth()->user()->emp_id;
            $files = ResponsibleLawyer::where('lawyer_id', '=', $lawyer_id)->pluck('file_id')->toArray();
            $lawsuit = Lawsuit::whereIn('id', $files)
                ->where('lawsuit_result', '=', $type);
            if (isset($start) && isset($end))
                $lawsuit = $lawsuit->whereBetween('open_date', [$start, $end]);

            $lawsuit = $lawsuit->count();

        }

        return $lawsuit;

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
}
