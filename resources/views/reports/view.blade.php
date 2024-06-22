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
                        {{Form::open(['url'=>url('lawsuit/report'),'class'=>'form-horizontal','method'=>"post","id"=>"report_form"])}}
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">رقم الملف</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input name="file_no" id="file_no" type="text"
                                                       class="form-control input-left"
                                                       placeholder="" value="">
                                                <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">تاريخ الملف</label>
                                        <div class="col-md-6">
                                            <div class="margin-bottom-5">
                                                <input type="text" class="form-control form-filter input-sm date-picker"
                                                       id="attend_date" name="attend_date" placeholder="From"
                                                       data-date-format="yyyy-mm-dd"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">نوع القضية</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
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
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">نوع الدعوى</label>
                                        <div class="col-md-6">
                                            <div class="input-icon input-group col-md-12">
                                                <i class="fa fa-balance-scale"></i>
                                                <input name="suit_type" id="suit_type" type="text"
                                                       class="form-control input"
                                                       placeholder="نوع الدعوى" value=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">المحكمة</label>
                                        <div class="col-md-6 ">
                                            <div class="input-group">
                                                <select id="court_id" name="court_id" class="form-control select2 ">

                                                    <option value="">اختر قيمة</option>


                                                    <?php

                                                    foreach ($courts as $court) {

                                                        echo '<option value="' . $court->id . '">' . $court->desc . '</option>';
                                                    }

                                                    ?>


                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">القاضي</label>
                                        <div class="col-md-6">
                                            <div class="input-icon">
                                                <i class="icon-user"></i>
                                                <input name="judge" id="judge" type="text" class="form-control input"
                                                       placeholder="القاضي" value=""></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="multiple" class="control-label col-md-4">المحامي</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <select id="lawyers" name="lawyers"
                                                        class="form-control select2-multiple">

                                                    <option value="0">اختر قيمة</option>


                                                    <?php
                                                    //&& auth()->user()->emp_id != $lawyer->emp_id
                                                    foreach ($lawyers as $lawyer) {
                                                        if ((auth()->user()->user_role != 3 && auth()->user()->user_role != 5) && auth()->user()->emp_id != $lawyer->emp_id)
                                                        //    echo '<option value="' . $lawyer->emp_id . '">' . auth()->user()->user_role . '</option>';
                                                         continue;
                                                        else
                                                            echo '<option value="' . $lawyer->emp_id . '">' . $lawyer->name . '</option>';
                                                    }

                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="multiple" class="control-label col-md-4">مصدر القضية</label>
                                        <div class="col-md-6">
                                            <select id="lawsources" name="lawsources"
                                                    class="form-control select2-multiple"
                                                    >

                                                <option value="0">اختر قيمة</option>


                                                <?php

                                                foreach ($externalEmps as $externalEmp) {

                                                    echo '<option value="' . $externalEmp->id . '">' . $externalEmp->name . '</option>';
                                                }

                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">رقم الدعوى في الشرطة</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input name="police_file_no" id="police_file_no" type="text"
                                                       class="form-control input-left"
                                                       placeholder="" value="">
                                                <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">حالة الدعوى</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <select id="file_status" name="file_status"
                                                        class="form-control select2">
                                                    <option value="0">اختر قيمة</option>


                                                    <?php

                                                    foreach ($fileStatus as $fileSt) {

                                                        echo '<option value="' . $fileSt->id . '">' . $fileSt->desc . '</option>';
                                                    }

                                                    ?>


                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">رقم هوية الموكل</label>
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <input name="agent_national_id" id="agent_national_id" type="text"
                                                       class="form-control input-left"
                                                       placeholder="" value="">
                                                <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>

                        </div>
                        <div class="form-actions left">
                            <div class="row">
                                <div class=" col-md-9">
                                    <button type="button" class="btn green" onclick="viewReport();">عرض</button>

                                </div>
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
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> {{$page_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="col-md-2">

                            </div>
                            <div class="col-md-2">
                            </div>
                            <div class="col-md-8">
                                <a style="float: left"
                                   class="dt-button button-excel2 buttons-html5 btn yellow btn-outline"
                                   tabindex="0" aria-controls="data-table" href="#"><i
                                        class="fa fa-file-excel-o"></i>Excel</a>
                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="report_tbl">
                            <thead>
                            <tr>
                                <th> #</th>
                                <th> المحكمة</th>
                                <th>الموكل</th>
                                <th> الخصم</th>
                                <th> نوع الدعوى</th>
                                <th> قيمة الدعوى</th>
                                <th> رقم الدعوة</th>
                                <th>تاريخ الإجراء</th>
                                <th>تاريخ الجلسة</th>
                                <th>إجراءات الدعوى</th>
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
            .datepicker {
                width: 15%;

            }
        </style>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
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
        {{--<script>
            $(document).ready(function() {
                $('#attendance_date').datepicker({
                    beforeShow: function(input, inst)
                    {
                        $.datepicker._pos = $.datepicker._findPos(input); //this is the default position
                        $.datepicker._pos[0] = whatever; //left
                        $.datepicker._pos[1] = whatever; //top
                    }
                });
            })
        </script>--}}

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
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


            function viewReport() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('#report_tbl').DataTable().destroy();
                var formData = new FormData();
                formData.append('court_file_no', $('#court_file_no').val());
                formData.append('judge', $('#judge').val());

                //  var form = $('#report_form');
                // alert(attend_date)
                $('#report_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    buttons: [
                        {
                            extend: 'excel',
                            className: 'btn yellow btn-outline ',
                            exportOptions: {
                                columns: [0, 1, 2,3,4,5,6,7,8,9]
                            }
                        }

                    ],
                    "dom": "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>", // horizobtal scrollable datatable

                    'ajax': {
                        "type": "post",
                        "url": "lawsuit/report",

                        "data": {
                            'file_no': $('#file_no').val(),
                            'attend_date': $('#attend_date').val(),
                            'lawsuit_type': $('#lawsuit_type').val(),
                            'suit_type': $('#suit_type').val(),
                            'court_id': $('#court_id').val(),
                            'judge': $('#judge').val(),
                            'lawyers': $('#lawyers').val(),
                            'lawsources': $('#lawsources').val(),
                            'police_file_no': $('#police_file_no').val(),
                            'lawsuit_type': $('#lawsuit_type').val(),
                            'file_status':$('#file_status').val(),
                            "agent_national_id":$('#agent_national_id').val(),


                        }
                        ,

                    },


                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'court_name', name: 'court_name'},
                        {data: 'agent_name', name: 'agent_name'},
                        {data: 'respondent_name', name: 'respondent_name'},
                        {data: 'lawsuitColor', name: 'lawsuitColor'},
                        {data: 'lawsuit_value', name: 'lawsuit_value'},
                        {data: 'file_no', name: 'file_no'},
                        {data: 'procedure_date', name: 'procedure_date'},
                        {data: 'session_date', name: 'session_date'},
                        {data: 'session_text', name: 'session_text'},


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
                $('.buttons-excel').addClass('hidden');
                $('.button-excel2').click(function () {
                    $('.buttons-excel').click()
                });

            }

        </script>
    @endpush
@stop
