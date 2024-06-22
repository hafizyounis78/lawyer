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
                            <span class="caption-subject bold uppercase">{{$page_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (in_array(11, auth()->user()->user_per))
                                        <div class="btn-group">
                                            <a href="{{url('/task/create')}}" class="btn sbold green"> اضافة مهمة جديدة
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="task_tbl">
                            <thead>
                            <tr>
                                <th style="background-color:#bfebbf"> #</th>
                                <th>تاريخ المهمة</th>
                                <th>المهمة</th>
                                <th>الموظف</th>
                                <th>الحالة</th>
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

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#task_tbl').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#task_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })
                $('#task_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/task-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'task_date', name: 'task_date', orderable: true},
                        {data: 'task_desc', name: 'task_desc', orderable: true},
                        {data: 'employee_name', name: 'employee_name', orderable: true},
                        {data: 'statusColor', name: 'statusColor',orderable: true},
                        {data: 'action', name: 'action'},

                    ],
                    aoColumnDefs: [
                        {bSortable: false, aTargets: ["_all"]}
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
            })
            function deleteTask(id) {
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
                        url: '{{url('task/deleteTask')}}',
                        data: {id: id},

                        success:

                            function (data) {


                                    location.reload();



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
