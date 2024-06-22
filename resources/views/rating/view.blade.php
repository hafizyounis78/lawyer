@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <h1 class="page-title"> {{$title}}
            <small>{{$page_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {{$page_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                @if (in_array(56, auth()->user()->user_per))
                                    <div class="col-md-3">
                                        <div class="btn-group">
                                            <a href="{{url('/rating/create')}}" class="btn sbold green">اضافة تقيم جديدة
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>

                                    </div>
                                @endif


                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="users_tbl">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> الاسم</th>
                                <th> رقم الهوية</th>
                                {{--    <th>الوظيفه</th>--}}
                                <th> نظام التقييم</th>
                                <th> تاريخ التقييم</th>
                                <th> الدرجة</th>
                                <th>عرض</th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    @push('css')

        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
    @endpush
    @push('js')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <script>

            /*  $(function() {
                  $('#form_datetime').datepicker({ dateFormat: 'yyy-dd-mm HH:MM:ss' }).val();
              });*/
            //  $("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd ");
        </script>

        <script>
            $(document).ready(function () {
                $('#users_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/rating-data')}}',
                    /*id`, `name`, `email`, ``, ``, `gender`, `address`, `mobile`, `image`, `user_type`, ``, `company_id`, `supervisor_id`, ``*/
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'emp_name', name: 'emp_name'},
                        {data: 'emp_national_id', name: 'emp_national_id'},
                        /*     {data: 'title', name: 'title'},*/
                        {data: 'system_name', name: 'system_name'},
                        {data: 'eval_date', name: 'eval_date'},
                        {data: 'eval_result', name: 'eval_result'},
                        {data: 'action', name: 'action'}

                    ]

                })
            })

            function eval_confirm(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('rate/confirmRate')}}',
                    data: {id: id},

                    success:

                        function (data) {
                            if (data.success) {

                                $('#btn_edit_' + id).fadeOut();
                                $('#btn_delete_' + id).fadeOut();
                                $('#btn_confirm_' + id).fadeOut();
                                var cuurent_tr = $('#btn_confirm_' + id).closest('td');
                                cuurent_tr.html('<span class="label label-sm label-success"> معتمد </span>');


                            }
                        }

                    ,
                    error: function (err) {

                        console.log(err);
                    }

                })

            }
            function deleteEval(id) {
                var x = '';
                var r = confirm('سيتم حذف القيمة ,هل انت متاكد من ذلك؟');
                var currentToken = $('meta[name="csrf-token"]').attr('content');


                if (r == true) {
                    x = 1;
                } else {
                    x = 0;
                }
                if (x == 1) {

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: "POST",
                        url: '{{url('rate/deleteRate')}}',
                        data: {id: id},

                        success:

                            function (data) {
                                if (data.success) {


                                    var cuurent_tr = $('#btn_confirm_' + id).closest('tr');
                                    cuurent_tr.fadeOut();


                                }
                            }

                        ,
                        error: function (err) {

                            console.log(err);
                        }

                    })
                }
            }
        </script>
    @endpush
@stop
