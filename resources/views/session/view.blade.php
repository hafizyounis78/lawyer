@extends('admin.layout.index')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token()}}">
    <div class="page-content">
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
                            <i class="icon-settings font-dark"></i>{{$page_title}}&nbsp;-&nbsp;رقم الملف&nbsp;(<label
                                id="file_no">{{$one_lawsuit->file_no}}</label>)
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (in_array(39, auth()->user()->user_per))
                                    <div class="btn-group">
                                        <a href="{{url('/session/create')}}" class="btn sbold green"> اضافة جلسة جديدة
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="datatable_tbl">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th>تاريخ الجلسة </th>
                                <th>تفصيل الجلسة</th>
                                <th>ملاحظات</th>
                                <th>تحكم</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>

    @push('js')


        <script src="{{url('/')}}/assets/pages/scripts/components-bootstrap-switch.js" type="text/javascript"></script>
        <script>

            $(document).ready(function () {
                $('#datatable_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/session-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'session_date', name: 'session_date'},
                        {data: 'session_text', name: 'session_text'},
                        {data: 'comments', name: 'comments'},
                        /*{data: 'reminder', name: 'reminder'},
                        {data: 'sms', name: 'sms'},*/
                        {data:'action', name: 'action'},],

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
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
            })


        </script>

    @endpush
@stop
