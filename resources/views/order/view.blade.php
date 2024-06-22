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
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">{{$page_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (in_array(43, auth()->user()->user_per))
                                    <div class="btn-group">
                                        <a href="{{url('/order/create')}}" class="btn sbold green"> اضافة طلب جديدة
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
                                <th>تاريخ الطلب </th>
                                <th>نوع الطلب</th>
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
        <script>
            $(document).ready(function () {
                $('#lawsuit_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/order-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'order_date', name: 'order_date'},
                        {data: 'order_text', name: 'order_text'},
                        {data: 'comments', name: 'comments'},
                        {data:'action', name: 'action'},]
                    ,
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
