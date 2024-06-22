@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <h1 class="page-title"> {{$title}}
            <small>{{$page_title}}</small>
        </h1>
        <div class="page-bar">
            @include('admin.layout.breadcrumb')

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box green-meadow">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{$page_title}}</div>
                        <div class="tools">
                            @if (in_array(32, auth()->user()->user_per))
                                <div class="col-md-6">

                                    <div class="btn-group">
                                        <a href="{{url('/sms/create')}}" class="btn sbold yellow-crusta">رسالة جديدة
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                </div>
                            @endif
                            @if (in_array(33, auth()->user()->user_per))
                                <div class="col-md-6">

                                    <div class="btn-group">
                                        <a href="{{url('/reminder/create')}}" class="btn sbold red-haze"> تنبيه جديدة
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>

                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="tabbable-custom ">
                            <ul class="nav nav-tabs ">
                                <li >
                                    <a href="#tab_sms" data-toggle="tab">الرسائل </a>
                                </li>
                                <li class="active">
                                    <a href="#tab_reminder" data-toggle="tab"> التنبيهات </a>
                                </li>

                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane " id="tab_sms">
                                    <table
                                        class="table table-striped table-bordered table-hover table-checkable order-column"
                                        id="sms_tbl">
                                        <thead>
                                        <tr>
                                            <th style="background-color:#bfebbf"> #</th>
                                            <th>تاريخ الرسالة</th>
                                            <th>النص</th>
                                            <th>المرسل</th>
                                            <th>الجوال</th>
                                            <th>نوع الرسالة</th>

                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane active" id="tab_reminder">
                                    <table
                                        class="table table-striped table-bordered table-hover table-checkable order-column"
                                        id="reminder_tbl">
                                        <thead>
                                        <tr>
                                            <th style="background-color:#bfebbf"> #</th>
                                            <th>تاريخ التنبيه</th>
                                            <th>النص</th>
                                            <th>الموظف</th>
                                            <th>رقم ملف القضية</th>
                                            <th>النوع</th>
                                            {{-- <th>تحكم</th>--}}
                                        </tr>
                                        </thead>
                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('js')
        <script>
            $(document).ready(function () {
                $('#sms_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/sms-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'sms_text', name: 'sms_text'},
                        {data: 'created_by_name', name: 'created_by_name'},
                        {data: 'mobile', name: 'mobile'},
                        {data: 'sms_type_desc', name: 'sms_type_desc'},


                    ],
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
                $('#reminder_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/reminder-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'reminder_date', name: 'reminder_date'},
                        {data: 'event_text', name: 'event_text'},
                        {data: 'emp_name', name: 'emp_name'},
                        {data: 'lawsuit_file_no', name: 'lawsuit_file_no'},
                        {data: 'reminder_type_desc', name: 'reminder_type_desc'},


                    ],
                    "order": [[ 1, "desc" ]],
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "No records found",
                        "infoFiltered": "(filtered1 from _MAX_ total records)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "No matching records found",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
            })
            function show_lawysuit(id) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('set-id')}}',
                    data: {id: id},

                    success: function (data) {

                        window.location.href = '{{url('/')}}/show-lawsuit';
                    }

                    ,
                    error: function (err) {

                        console.log(err);
                    }

                });
            }
        </script>
    @endpush
@stop
