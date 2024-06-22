<?php

namespace App\Http\Controllers;

use App\Agent;
use App\Employee;
use App\ResponsibleLawyer;
use App\Sms;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  dd('ffff');
        if (in_array(31, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'sms';
            $this->data['location_title'] = 'عرض الرسائل والتنبيهات';
            $this->data['location_link'] = 'sms';
            $this->data['title'] = 'الرسائل والتنبيهات';
            $this->data['page_title'] = 'عرض الرسائل';
            return view(message_vw() . '.view')->with($this->data);
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
//dd('fff');
        if (in_array(32, auth()->user()->user_per)) {
            $this->data['sub_menu'] = 'sms';
            $this->data['location_title'] = 'عرض الرسائل والتنبيهات';
            $this->data['location_link'] = 'sms';
            $this->data['title'] = 'الرسائل والتنبيهات';
            $this->data['page_title'] = 'اضافة رسالة جديدة';
            //   $this->data['lawyers'] = getLookupLawyers();
            return view(message_vw() . '.create')->with($this->data);
        }
        return redirect()->back();
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
        $sms_type = $request->smc_type;

        if ($sms_type == 1 || $sms_type == 2) {
            $file_id = $request->hdn_file_id;
            $refernce_id = $request->refernce_id;


            $mobileList = $request->respondant;
            //dd(count($mobileList));
            for ($i = 0; $i < count($mobileList); ++$i) {
                $sms = new Sms();
                $sms->sms_text = $request->sms_text;
                $sms->mobile = $mobileList[$i];
                $sms->send_date = $request->send_date;
                $sms->sms_type = $request->smc_type;

                $sms->reference_id = $refernce_id;
                $sms->created_by = auth()->user()->id;
                $sms->save();
                //   echo $mobileList[$i];
                $this->sendSMS($mobileList[$i], $request->sms_text);
            }
            //  dd('ff');
            $results = Sms::where('reference_id', $request->refernce_id)
                ->where('sms_type', $sms_type)
                ->get();
            $html = '';
            foreach ($results as $result) {
                $html .= '<tr>';
                $html .= '<td>' . $result->sms_text . '</td>';
                $html .= '<td>' . $result->mobile . '</td>';
                $html .= '<td>' . $result->send_date . '</td></tr > ';
            }
            return response()->json(['success' => true, 'table' => $html]);

        } else {

            $refernce_id = '';
            $sms = new Sms();
            $sms->sms_text = $request->sms_text;
            $sms->mobile = $request->mobile;
            $sms->send_date = date('Y-m-d H:i:s');
            $sms->sms_type = $request->smc_type;

            $sms->created_by = auth()->user()->id;
            $sms->save();
            $this->sendSMS($request->mobile, $request->sms_text);
            /*
             * Api send sms
             * */

            return response()->json(['success' => true]);
        }


    }

    public function smsData()
    {
        $model = Sms::orderBy('created_at');


        $num = 1;

        return datatables()->of($model)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('sms_type_desc', function ($model) {// as foreach ($users as $user)
                $html = '';
                if ($model->sms_type == 1)
                    $html = '<span class="bg-font-red btn bg-red">إجراءات</span>';
                else if ($model->sms_type == 2)
                    $html = '<span class="bg-font-red btn bg-blue">طلبات</span>';
                else if ($model->sms_type == 3)
                    $html = '<span class="bg-font-red btn bg-green">مهام</span>';
                else if ($model->sms_type == 4)
                    $html = '<span class="bg-font-red btn bg-yellow">عام</span>';

                return $html;
            })
            ->addColumn('created_by_name', function ($model) {// as foreach ($users as $user)

                if ($model->created_by != '') {
                    $user = User::find($model->created_by);
                    return $user->email;
                }
                return '';

            })
            ->rawColumns(['action', 'sms_type_desc'])
            ->toJson();

    }

    function sendSMS($mobile, $text)

    {

        $user_name = 'besiso firm';
        $user_pass = 2749294;
        $sender = 'besiso.firm';

        $sms_url = 'http://www.hotsms.ps/sendbulksms.php';
        $postvars = 'user_name=' . $user_name . '&user_pass=' . $user_pass . '&sender=' . $sender . '&mobile=' . $mobile . '&type=2&text=' . $text;
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sms_url);

        curl_setopt($ch, CURLOPT_POST, 1);

        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $result = trim(curl_exec($ch));
        dd($result);
        curl_close($ch);

        //   $headers = array('Content-Type: application/json');
        /*   $curl_handle = curl_init();
           curl_setopt($curl_handle, CURLOPT_URL, $sms_url);
           curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
           curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
           //curl_setopt($curl_handle, CURLOPT_USERAGENT, 'parent');
           //	curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
           $result = curl_exec($curl_handle);

           curl_close($curl_handle);*/
        //  dd($result);
        //  exit;
        return $result;

    }

    function sendScheduleSMS()

    {
        $user_name = 'besiso firm';
        $user_pass = 2749294;
        $sender = 'besiso.firm';

        $sms_url = 'http://www.hotsms.ps/sendbulksms.php';

        $sms = Sms::whereDate('send_date', '=', Carbon::today())->get();
        $postvars = '';
        $result = 0;
        foreach ($sms as $sm) {
            $postvars = 'user_name=' . $user_name . '&user_pass=' . $user_pass . '&sender=' . $sender . '&mobile=' . $sm->mobile . '&type=2&text=' . $sm->sms_text;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $sms_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            //  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            $result = trim(curl_exec($ch));
            dd($result);
            curl_close($ch);
        }


    }

    function test()
    {

        $TIME = "04:30 AM ";
        $PATIENT_NAME = "صالح ماهر محمود ابو امونه";
        $CLINIC = "عيادة العظام";
        $HOS = "الشفاء";

        // 1-SMS Text
        $msg_text = "السيد/ة: " . $PATIENT_NAME . " نذكرك بموعدك لمراجعة عيادة( " . $CLINIC . ") بمستشفى( " . $HOS . ") غدا الساعة " . $TIME . " يرجى الالتزام بالموعد.";

        $message = urlencode($msg_text);
        //-------------------------
        // 2- SMS Title
        $title = urlencode("SMS_CLINIC");
        //-------------------------
        // 3- Mobile Num.
        $mobiles = "0598705552";
        //-------------------------
        // 4- Username && Passward
        $username = "Tawasl";
        $password = md5("2308761");

        $sms_url = "http://rasel.eapp.gov.ps/getway/c_api/send/$username/$password/MohTawasl/sms/" . $mobiles . "/" . $title . "/" . $message . "";

/*
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $sms_url);

        curl_setopt($ch, CURLOPT_POST, 1);

        //  curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        $result = trim(curl_exec($ch));

        if ($errno = curl_errno($ch)) {
            $error_message = curl_errno($errno);
            echo "cURL error ({$errno}):\n {$error_message}";
            echo PHP_EOL;
        }
        curl_close($ch);*/
        $_h = curl_init();
        curl_setopt($_h, CURLOPT_HEADER, 1);
        curl_setopt($_h, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($_h, CURLOPT_HTTPGET, 0);
        curl_setopt($_h, CURLOPT_URL, $sms_url);
        curl_setopt($_h, CURLOPT_DNS_USE_GLOBAL_CACHE, false );
        curl_setopt($_h, CURLOPT_DNS_CACHE_TIMEOUT, 2 );

        var_dump(curl_exec($_h));
        var_dump(curl_getinfo($_h));
        var_dump(curl_error($_h));

    }
}
