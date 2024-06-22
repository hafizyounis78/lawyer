<!doctype html>
<html dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Document</title>

    <link rel="stylesheet" media="screen" href="{{url('assets/xb-riyaz.css')}}" type="text/css"/>
    {{--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />--}}
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet"
          type="text/css"/>
    <style>
        /*@import url(http://fonts.googleapis.com/earlyaccess/droidarabickufi.css);*/
        body, th, td {
            font-family: 'xbriyaz', sans-serif;

        }

        th, td {
            font-size: 13;

        }

        td {
            font-size: 12;

        }

        .table-title {
            border: 0;
        }

        .table, th, td {

            border: 1px solid grey;

        }

        .table {

            border-collapse: collapse;

        }

        th {
            text-align: right !important;
            /*   width: 20% !important;*/
        }

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1em 0;
            padding: 0;

        }

        .column {
            float: left;
            width: 50%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @page {
            header: html_otherpages;
            footer: page-footer;
        }


        @page :first {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>
<body>
<htmlpageheader name="page-header">

    <img alt="" class="img-circle" src=" {{auth()->user()->org_logo}}" width="15%"/>


</htmlpageheader>
<htmlpageheader name="otherpages" style="display:none">
    <div style="text-align:center">{PAGENO}</div>
</htmlpageheader>
<sethtmlpageheader name="page-header" value="on" show-this-page="1" />
<sethtmlpageheader name="otherpages" value="on" />
<div style="width: 100%; text-align: center">
    <h1 class="page-title"> تقرير بملف الدعوى</h1>
</div>
<br/>
<div class="page-content">

    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            <th> رقم الملف</th>
            <td colspan="2">{{$one_lawsuit->file_no}} </td>
            <th>رقم الدعوى في الشرطة</th>
            <td>{{$one_lawsuit->police_file_no}} </td>
        </tr>

        <tr>
            <th>المحكمة</th>
            <td colspan="2"> {{$one_lawsuit->court_name}}</td>
            <th>رقم الدعوى في المحكمة</th>
            <td>{{$one_lawsuit->court_file_no}} </td>
        </tr>
        <tr>
            <th> نوع الدعوى</th>
            <td colspan="2"> {{$one_lawsuit->type_desc}}</td>
            <th>رقم الدعوى في الإستئناف</th>
            <td> {{$one_lawsuit->appeal_file_no}}</td>
        </tr>
        <tr>
            <th> تفصيل الدعوى</th>
            <td colspan="2"> {{$one_lawsuit->suit_type}}</td>
            <th>رقم الدعوى في النقض</th>
            <td> {{$one_lawsuit->veto_file_no}}</td>
        </tr>
        <tr>
            <?php $currncy = [0 => '', 1 => 'NIS', 2 => 'US', 3 => 'JOD']?>
            <th> قيمة الدعوى</th>
            <td>{{$one_lawsuit->lawsuit_value.' '.$currncy[$one_lawsuit->currency]}} </td>
            <td>{{$one_lawsuit->lawsuit_value2.' '.$currncy[$one_lawsuit->currency2]}} </td>
           
            <th>رقم الدعوى التنفيذية</th>
            <td>{{$one_lawsuit->executive_file_no}} </td>

        </tr>
        <tr>
            <th>جهة الدعوى</th>
            <td colspan="2" > {{$one_lawsuit->judge}}</td>
            <th>رقم الدعوى في النيابة العامة</th>
            <td>{{$one_lawsuit->prosecution_file_no}} </td>

        </tr>
        <tr>
            <th>المحامي</th>
            <td colspan="2"> {{$one_lawsuit->lawyers_name}}</td>
            <th>رقم الشكوى</th>
            <td> {{$one_lawsuit->complaint_no}}</td>

        </tr>

        <tr>
            <th> حركة الملف</th>
            <td colspan="2"> {{$one_lawsuit->file_location_desc}}</td>
            <th>رقم الإخطار</th>
            <td> {{$one_lawsuit->noti_file_no}}</td>
        </tr>
        <tr>
            <th> مصدر الدعوى</th>
            <td colspan="2"> {{isset($lawsuit_sources->lawyer_id)?$lawsuit_sources->lawyer_id:''}}</td>
            <th>حالة الدعوى</th>
            <td>{{$one_lawsuit->file_status_desc}} </td>
        </tr>
        <tr>
            <th>ملاحظات</th>
            <td colspan="2"> {{$one_lawsuit->lawsuit_note}}</td>
            <th>نتيجة الدعوى</th>
            <td> {{$one_lawsuit->lawsuit_result_desc}}</td>
        </tr>

        </thead>

    </table>
    <h2>الموكيلين</h2>
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            {{--  <th> #</th>--}}
            <th> رقم الهوية</th>
            <th> الاسم</th>
            <th> جوال</th>
            <th> العنوان</th>
            <th> البريد الإلكتروني</th>
            <th>رقم هوية الوكيل</th>
            <th> اسم الوكيل</th>

        </tr>
        </thead>
        <tbody id="tb_agent">
        {!!  $agents; !!}
        </tbody>
    </table>
    <h2>الخصوم</h2>
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            {{--  <th> #</th>--}}
            <th> رقم الهوية</th>
            <th> الاسم</th>
            <th> جوال</th>
            <th> عنوان</th>


        </tr>
        </thead>
        <tbody id="tb_respondents">
        {!!  $respondents; !!}
        </tbody>
    </table>

    <h2>الإجراءات</h2>
    <table class="table " width="100%" id="report_tbl" cellpadding="10">
        <thead>
        <tr>
            {{--  <th> #</th>--}}

            <th width="10%"> #</th>
            <th width="10%">تاريخ</th>
            <th width="80%"> الإجراء</th>


        </tr>
        </thead>
        <tbody id="tb_respondents">
        {!!  $procedures; !!}
        </tbody>
    </table>

</div>
<htmlpagefooter name="page-footer">
    <div class="row">

        <div class="column">
            صفحة رقم {nb}/{PAGENO}
        </div>
        <div class="column">
            تاريخ الطباعة : {{ date('d-m-Y') }}
        </div>

    </div>

</htmlpagefooter>
</body>
</html>
