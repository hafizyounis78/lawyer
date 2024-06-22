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
                                        <a href="{{url('/procedure/create')}}" class="btn sbold green"> اضافة اجراء جديدة
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="lawsuit_tbl">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th>تاريخ الإجراء </th>
                                <th>الإجراء</th>
                                <th>ملاحظات</th>
                             {{--   <th>تذكير</th>
                                <th>sms</th>--}}
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
                $('#lawsuit_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/procedure-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'prcd_date', name: 'prcd_date'},
                        {data: 'prcd_text', name: 'prcd_text'},
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

            jQuery(document).ready(function() {
                ComponentsBootstrapSwitch.init();
            });
           /* function saveSession(id,url) {
                alert('Hi');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('proc-set-id')}}',

                    data: {id: id,url:url},
                    error: function (xhr, status, error) {

                    },
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {
                        window.location.href = '{{url('/')}}/'+url;

                    }
                });//END $.ajax
            }*/
        </script>

    @endpush
@stop
