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
            font-size: 13px;

        }

        td {
            font-size: 12px;

        }

        .table-title {
            border: 0;
        }

        .table, th, td {

            border: 1px solid grey;

        }

        .table {
            width: 100% !important;
            border-collapse: collapse;

        }

        th {
            text-align: right !important;
            /*   width: 20% !important;*/
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

        hr {
            display: block;
            height: 1px;
            border: 0;
            border-top: 1px solid #ccc;
            margin: 1em 0;
            padding: 0;

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
<div style="width: 100%; text-align: center">
    <h1 class="page-title"> تقرير بملفات الموكل</h1>
</div>
<br/>
<br/>
<br/>
<div class="page-content">
    <meta name="csrf-token" content="{{ csrf_token()}}">


    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered">
                <div class="portlet-title">


                </div>
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="col-md-2">

                        </div>
                        <div class="col-md-2">
                        </div>

                    </div>
                    <table border="1" class="table" id="report_tbl" cellpadding="5">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> المحكمة</th>
                            <th>الموكل</th>
                            <th> الخصم</th>
                            <th> نوع الدعوى</th>
                            <th colspan="2"> قيمة الدعوى</th>
                            <th> رقم الدعوى</th>
                            <th>تاريخ آخر إجراء</th>
                            <th>تاريخ الجلسة</th>
                            <th>إجراءات الدعوى</th>
                        </tr>
                        </thead>
                        <tbody>
                        {!! $html !!}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
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
