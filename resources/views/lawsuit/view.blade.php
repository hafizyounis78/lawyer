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
        <div class="row" id="searchDv">
            <div class="col-md-12 ">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo">
                            <i class="icon-settings font-red-sunglo"></i>
                            <span class="caption-subject bold uppercase">معايير البحث</span>
                        </div>
                        {{--<div class="actions">
                            <div class="btn-group">

                                <a href="{{url('/attendance/create')}}" class="btn sbold green">اضافة حركات جديدة
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>--}}
                    </div>
                    <div class="portlet-body form">
                        {{Form::open(['url'=>url('lawsuit/pdf'),'class'=>'horizontal-form','method'=>"post","id"=>"report_form"])}}
                        <div class="form-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الملف</label>
                                        <input name="file_no" id="file_no" type="text" class="form-control"
                                               placeholder="رقم الملف">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">الاسم</label>
                                        <input name="name" id="name" type="text" class="form-control"
                                               placeholder="الاسم">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">نوع الدعوى</label>
                                        <select id="lawsuit_type" name="lawsuit_type"
                                                class="form-control select2">
                                            <option value="0">اختر قيمة</option>


                                            <?php

                                            foreach ($lawsuitTypes as $lawsuitType) {

                                                echo '<option value="' . $lawsuitType->id . '">' . $lawsuitType->desc . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">حالة الدعوى</label>
                                        <select id="file_status" name="file_status"
                                                class="form-control select2">
                                            <option value="0">اختر قيمة</option>


                                            <?php

                                            foreach ($FileStatuses as $FileStatus) {

                                                echo '<option value="' . $FileStatus->id . '">' . $FileStatus->desc . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى في الشرطة</label>
                                        <input type="text" id="police_file_no" name="police_file_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى في المحكمة</label>
                                        <input type="text" id="court_file_no" name="court_file_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى في الإستئناف</label>
                                        <input type="text" id="appeal_file_no" name="appeal_file_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى في النقض</label>
                                        <input type="text" id="veto_file_no" name="veto_file_no" class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى التنفيذية</label>
                                        <input type="text" id="executive_file_no" name="executive_file_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الدعوى في النيابة العامة</label>
                                        <input type="text" id="prosecution_file_no" name="prosecution_file_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الشكوى</label>
                                        <input type="text" id="complaint_no" name="complaint_no" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="control-label">رقم الإخطار</label>
                                        <input type="text" id="noti_file_no" name="noti_file_no" class="form-control">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions left">
                            <div class="row">
                                <button type="button" class="btn green" onclick="reloadtable();">عرض</button>
                                <button type="button" onclick="clearForm()" class="btn  red-intense">الغاء</button>
                            </div>
                        </div>

                        {{Form::close()}}
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->

            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="col-md-6">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">{{$page_title}}</span>
                            </div>
                        </div>
                        <div class="actions">
                            <div class="btn-group">

                                <button type="button" onclick="openDv()" class="btn  yellow-lemon">
                                    <i class="fa fa-search"></i></button>

                            </div>
                        </div>
                        {{-- <div class="col-md-6">
                             <ul class="nav nav-pills">
                                 <li class="">
                                     <a href="javascript:;"> الدعاوي المفتوحة
                                         <span class="badge badge-primary "> {{$open_files}} </span>
                                     </a>
                                 </li>
                                 <li>
                                     <a href="javascript:;"> جلسات
                                         <span class="badge badge-warning"> {{$session_files}} </span></a>
                                 </li>
                                 <li>
                                     <a href="javascript:;"> الدعاوي المغلقة
                                         <span class="badge badge-danger">  {{$closed_files}} </span>
                                     </a>
                                 </li>
                             </ul>
                         </div>--}}
                    </div>


                    {{--       <div class="row list-separated profile-stat">
                               <div class="col-md-4 col-sm-4 col-xs-6">
                                   <div class="uppercase profile-stat-title"> {{$result1}} </div>
                                   <div class="uppercase profile-stat-text label label-success"> ايجابي </div>
                               </div>
                               <div class="col-md-4 col-sm-4 col-xs-6">
                                   <div class="uppercase profile-stat-title"> {{$result2}} </div>
                                   <h3><span class="label label-danger"> سلبي </span></h3>
                               </div>
                               <div class="col-md-4 col-sm-4 col-xs-6">
                                   <div class="uppercase profile-stat-title"> {{$result3}} </div>
                                   <div class="uppercase profile-stat-text"> صلح </div>
                               </div>
                           </div>--}}
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">
                                @if (in_array(9, auth()->user()->user_per))
                                    <div class="col-md-6">
                                        <div class="btn-group">
                                            <a href="{{url('/lawsuit/create')}}" class="btn sbold green"> فتح دعوى
                                                جديدة
                                                <i class="fa fa-plus"></i>
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <table class="table table-striped table-bordered table-hover " id="lawsuit_tbl">
                            <thead>
                            <tr>
                                <th width="5%"> #</th>
                                <th width="10%"> رقم الملف</th>
                                {{--  <th width="10%">نوع القضية</th>--}}
                                <th width="15%">نوع الدعوى</th>
                                <th width="14%">الموكلين</th>
                                <th width="14%">الخصم</th>

                                {{-- <th> جوال </th>--}}
                                <th width="10%">تاريخ اخر اجراء</th>
                                <th width="10%">الإجراء</th>
                                <th width="5%">تاريخ الجلسة</th>
                                <th width="10%"> حالة الدعوى</th>
                                <th width="17%">تحكم</th>
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
        <style>
            .badge {
                width: 100%;
                height: 25px;
                font-size: 0.8em !important;

            }
            .table-scrollable .dataTable td > .btn-group, .table-scrollable .dataTable th > .btn-group {
                position: relative !important;
                margin-top: -2px;
            }
            @media only screen and (max-width: 768px) {

                .btn-group>.dropdown-menu {
                    margin-right: -92px;
                }
            }
        </style>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-toastr/toastr-rtl.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet"
              type="text/css"/>
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-toastr/toastr.min.js"></script>
        <script src="{{url('')}}/assets/pages/scripts/ui-toastr.js"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>
        <script>
            function openDv() {
                $('#searchDv').fadeIn();
            }

            function clearForm() {
                $('#lawsuit_type').val(0);
                $('#file_status').val(0);
                $('.select2').trigger('change');
                $('#name').val('');
                $('#searchDv').fadeOut();
                reloadtable();

            }

            $(document).ready(function () {
                $('#searchDv').fadeOut();
                reloadtable();

            });

            function reloadtable() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#lawsuit_tbl').DataTable().destroy();
                $('#lawsuit_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": "lawsuit-data",

                        "data": {
                            'lawsuit_type': $('#lawsuit_type').val(),
                            'file_status': $('#file_status').val(),
                            "name": $('#name').val(),
                            "file_no": $('#file_no').val(),
                            "police_file_no": $('#police_file_no').val(),
                            "court_file_no": $('#court_file_no').val(),
                            "appeal_file_no": $('#appeal_file_no').val(),
                            "veto_file_no": $('#veto_file_no').val(),
                            "executive_file_no": $('#executive_file_no').val(),
                            "prosecution_file_no": $('#prosecution_file_no').val(),
                            "complaint_no": $('#complaint_no').val(),
                            "noti_file_no": $('#noti_file_no').val(),

                        }
                        ,

                    },

                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'lawsuit_file_no', name: 'lawsuit_file_no'},
                        {data: 'lawsuitColor', name: 'lawsuitColor'},
                        /*     {data: 'suit_type', name: 'suit_type'},*/
                        {data: 'agent_name', name: 'agent_name'},//الموكل
                        {data: 'respondent_name', name: 'respondent_name'},//المدعى عليه
                        /*                        {data: 'lawsuit_value', name: 'lawsuit_value'},//جوال*/
                        /* {data: 'image', name: 'image'},*/
                        /*{data: 'judge', name: 'judge'},*/
                        {data: 'last_procedure_date', name: 'last_procedure_date'},
                        {data: 'last_procedure_text', name: 'last_procedure_text'},
                        {data: 'future_session_date', name: 'future_session_date'},
                        {data: 'file_status_desc', name: 'file_status_desc'},

                        {data: 'action', name: 'action'},


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
            }

            /*  function show_lawysuit(id) {

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

                        window.location.href = '{{url('/')}}/edit-lawsuit';
                    }

                    ,
                    error: function (err) {

                        console.log(err);
                    }

                });
            }*/
            function saveSession(id, url) {
                //   alert(url);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: '{{url('set-id')}}',

                    data: {id: id, url: url},
                    error: function (xhr, status, error) {

                    },
                    beforeSend: function () {
                    },
                    complete: function () {
                    },
                    success: function (data) {

                        window.open('{{url('/')}}/' + url, '_blank');
                    }
                });//END $.ajax
            }

            function deleteLawsuit(id) {
                swal({
                        title: 'هل انت متاكد من ذلك؟',
                        text: "سيتم حذف ملف الدعوى",
                        type: 'error',
                        showCancelButton: true,
                        confirmButtonText: 'نعم ,احذف!',
                        cancelButtonText: 'لا, ‘الغاء العملية!',
                        reverseButtons: true
                    },
                    function (isConfirm) {
                        if (isConfirm) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: '{{url('lawsuit/del-one')}}',
                                data: {id: id},

                                success: function (data) {
                                    swal("نجاح", "تمت العملية بنجاح :)", "success");
                                    reloadtable();
                                },
                                error: function (err) {

                                    swal("خطأ", "لم تتم العملية :)", "error");
                                }

                            })

                        } else {
                            swal("إلغاء", "تم إلغاء العملية :)", "error");
                        }
                    });

                /* swal({
                     title: 'هل انت متاكد من ذلك؟',
                     text: "سيتم حذف ملف الدعوى",
                     type: 'error',
                     showCancelButton: true,
                     confirmButtonText: 'نعم ,احذف!',
                     cancelButtonText: 'لا, ‘الغاء العملية!',
                     reverseButtons: true
                 }).then(function (result) {
                     if (result.value) {
                         $.ajaxSetup({
                             headers: {
                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                             }
                         });

                         $.ajax({
                             type: "POST",
                             url: '{{url('lawsuit/del-one')}}',
                            data: {id: id},

                            success: function (data) {
                                set_message("تمت العملية بنجاح", true);
                                reloadtable();
                            },
                            error: function (err) {

                                console.log(err);
                            }

                        })

                        // result.dismiss can be 'cancel', 'overlay',
                        // 'close', and 'timer'
                    } else if (result.dismiss === 'cancel') {
                        swal(
                            'تم إلغاء العملية',
                            'error'
                        )
                    }
                });*/
                /* var x = '';
                 var r = confirm('سيتم حذف ملف الدعوى ,هل انت متاكد من ذلك؟');
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
                         url: '{{url('lawsuit/del-one')}}',
                        data: {id: id},

                        success: function (data) {
                            location.reload();
                        },
                        error: function (err) {

                            console.log(err);
                        }

                    })
                }*/
            }
        </script>
    @endpush
@stop
