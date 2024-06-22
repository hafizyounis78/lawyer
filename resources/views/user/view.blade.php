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
                                <div class="col-md-6">
                                    <div class="btn-group">
                                        <a href="{{url('/user/create')}}" class="btn sbold green"> اضافة مستخدم جديد
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="users_tbl">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> الاسم</th>
                                <th> البريد الإلكتروني</th>
                                <th> رقم الهوية</th>
                                <th>الوظيفه</th>
                                {{--<th> الصورة </th>--}}
                                <th>المحافظة</th>
                                <th> عنوان</th>
                                <th> جوال</th>
                                <th> حالة المستخدم</th>
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
                $('#users_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/user-data')}}',
                    /*id`, `name`, `email`, ``, ``, `gender`, `address`, `mobile`, `image`, `user_type`, ``, `company_id`, `supervisor_id`, ``*/
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'national_id', name: 'national_id'},
                        {data: 'job_title', name: 'job_title'},
                        /* {data: 'image', name: 'image'},*/
                        {data: 'district', name: 'district'},
                        {data: 'address', name: 'address'},
                        {data: 'mobile', name: 'mobile'},
                        {data: 'active', name: 'active'},
                        {data: 'action', name: 'action'},],
                    "language": {
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        },
                        "emptyTable": "لايوجد بيانات في الجدول للعرض",
                        "info": "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty": "لايوجد سجلات",
                        "infoFiltered": "(filtered1 من _MAX_ مجموع سجلات)",
                        "lengthMenu": "عرض _MENU_",
                        "search": "بحث:",
                        "zeroRecords": "لم يتم العثور على سجلات متطابقة",
                        "paginate": {
                            "previous": "Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
            })

            function deleteUser(id) {
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
                        url: '{{url('user/delete')}}',
                        data: {id: id},

                        success: function (data) {
                            location.reload();
                        },
                        error: function (err) {

                            console.log(err);
                        }

                    })
                }
            }

            function updateUserstatus(id) {
                var isactive = '';
                var newclass = '';
                var itemid = '#i' + id;
                var active_class = 'fa fa-user font-green';
                var unactive_class = 'fa fa-user font-red-sunglo';


                if ($(itemid).attr("class") == active_class) {

                    isactive = 0;
                    newclass = unactive_class;
                }
                else {
                    isactive = 1;
                    newclass = active_class;
                }
                if (isactive == 0) {
                    var x = '';
                    var r = confirm('سيتم ايقاف المستخدم,هل انت متأكد من ذلك؟');
                }
                else if (isactive == 1) {
                    var x = '';
                    var r = confirm('سيتم تفعيل المستخدم,هل انت متأكد من ذلك؟');
                }
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
                        url: '{{url('user/activate')}}',
                        type: "POST",
                        data: {id: id, isactive: isactive},
                        error: function (xhr, status, error) {

                        },
                        success: function (data) {
                            if (data.success) {


                                $('#i' + id).removeClass($('#i' + id).attr("class")).addClass(newclass);
                            }
                        }
                    });//END $.ajax
                }

            }
        </script>
    @endpush
@stop
