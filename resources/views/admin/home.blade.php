@extends('admin.layout.index')
@section('content')
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <meta name="csrf-token" content="{{ csrf_token()}}">
        <!-- BEGIN PAGE HEADER-->
        <!-- BEGIN THEME PANEL -->

    <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="">الصفحة الرئيسية</a>
                    {{--<i class="fa fa-angle-right"></i>--}}
                </li>
                {{-- <li>
                     <span></span>
                 </li>--}}
            </ul>
            <div class="page-toolbar">
                <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height green"
                     data-placement="top" data-original-title="Change dashboard date range"
                     data-date-format="yyyy/mm/dd">
                    <i class="icon-calendar"></i>&nbsp;
                    <span class="thin uppercase hidden-xs"></span>&nbsp;
                    <i class="fa fa-angle-down"></i>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> الأرشيف الإداري</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="sample_1">
                            <thead>
                            <tr>

                                <th> #</th>
                                <th>اسم الملف</th>
                                <th>نوع الملف</th>
                                <th>مكان الملف</th>
                                <th>ملاحظات</th>
                                <th>تاريخ الإضافة</th>


                            </tr>
                            </thead>
                            <tbody id="arch_td">
                            {!! $user_archs !!}
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> جلسات اليوم</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="session_tbl">
                            <thead>
                            <tr>

                                <th> #</th>
                                <th> رقم ملف الدعوى</th>
                                <th> نوع الدعوى</th>
                                <th> الموكلين</th>
                                <th> الخصوم</th>
                                <th> جهة الدعوى</th>
                                <th> المحكمة</th>
                                <th> الجلسة</th>
                                <th> تاريخ</th>

                            </tr>
                            </thead>
                            <tbody >

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> التنبيهات</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="reminder_tbl">
                            <thead>
                            <tr>

                                <th> #</th>
                                <th> النص</th>
                                <th> الموظف</th>
                                <th> رقم الملف</th>
                                <th> تاريخ</th>
                                <th> نوع التنبية</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> المهام</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">

                            </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover table-checkable order-column"
                               id="task_tbl">
                            <thead>
                            <tr>

                                <th> #</th>
                                <th> المهمة</th>
                                <th> الموظف</th>
                                <th> الحالة</th>
                                <th> تاريخ</th>
                                <th> تحكم</th>
                            </tr>
                            </thead>
                            <tbody id="task_td">

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>

        <div class="raw">
            <div class="portlet light ">
                <div class="portlet-title">
                    <div class="caption ">
                        <span class="caption-subject font-dark bold uppercase">الملفات القضائية</span>
                        <span class="caption-helper">انواع الملفات القضائية</span>
                    </div>
                    {{--<div class="actions">
                        <a href="#" class="btn btn-circle green btn-outline btn-sm">
                            <i class="fa fa-pencil"></i> Export </a>
                        <a href="#" class="btn btn-circle green btn-outline btn-sm">
                            <i class="fa fa-print"></i> Print </a>
                    </div>--}}
                </div>
                <div class="portlet-body">
                    <div id="dashboard_amchart_3" class="CSSAnimationChart"></div>
                </div>
            </div>
        </div>
        <!-- END PAGE HEADER-->

    </div>
    <div class="modal fade bs-modal-lg" id="taskModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">عرض المهمة</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN SAMPLE TABLE PORTLET-->

                            <div class="portlet box red-haze">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-gift"></i>عرض المهمة
                                    </div>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"> </a>

                                    </div>
                                </div>
                                <div class="portlet-body form">
                                    <!-- BEGIN FORM-->
                                    {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                                    {{Form::open(['url'=>"",'class'=>'form-horizontal','method'=>"post","id"=>"task_form"])}}

                                    <div class="form-body">


                                        <div class="form-group">
                                            <label class="control-label col-md-3">وقت وتاريخ المهمة
                                                <span class="required"> * </span></label>
                                            <div class="col-md-4">
                                                <div class="input-group date form_datetime" data-date=""
                                                     data-date-format="dd/mm/yyyy hh:mm:ss">
                                                    <input type="text" name="task_date" id="task_date" size="16"
                                                           readonly
                                                           value="" class="form-control" dir="ltr">
                                                    <span class="input-group-btn">

                                </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">المهمة
                                                <span class="required"> * </span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon">
                                                    <i class="icon-book-open"></i>
                                                    <textarea class="form-control" name="task_desc" id="task_desc"
                                                              rows="3" disabled></textarea>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                {{-- </form>--}}
                                {{Form::close()}}
                                <!-- END FORM-->
                                </div>
                            </div>
                            <!-- END SAMPLE TABLE PORTLET-->
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade bs-modal-lg" id="reminderModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true"></button>
                    <h4 class="modal-title">عرض التنبية</h4>
                </div>

                <div class="modal-body">
                    <div class="raw">

                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption" id="fileDv">
                                    <i class="fa fa-gift"> </i>&nbsp;&nbsp;-&nbsp;رقم الملف&nbsp;(<label
                                        id="file_no"></label>)
                                </div>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"> </a>

                                </div>
                            </div>
                            <div class="portlet-body form">
                                <!-- BEGIN FORM-->
                                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                                {{Form::open(['url'=>'','class'=>'form-horizontal','method'=>"post","id"=>"procedure_form"])}}

                                <div class="form-body">


                                    <div class="form-group">
                                        <label class="control-label col-md-3">وقت وتاريخ </label>
                                        <div class="col-md-6">
                                            <div class="input-group date form_datetime" data-date=""
                                                 data-date-format="dd/mm/yyyy hh:mm:ss">
                                                <input type="text" name="reminder_date" id="reminder_date" readonly
                                                       class="form-control" dir="ltr" disabled>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">تفصيل</label>
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                <i class="icon-book-open"></i>
                                                <textarea class="form-control" name="reminder_text" id="reminder_text"
                                                          rows="3" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">ملاحظات</label>
                                        <div class="col-md-4">
                                            <div class="input-icon">
                                                <i class="icon-book-open"></i>
                                                <textarea class="form-control" name="comments" id="comments"
                                                          rows="3" disabled></textarea>
                                            </div>
                                        </div>
                                    </div>


                                </div>


                                {{-- </form>--}}
                                {{Form::close()}}

                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn dark btn-outline" data-dismiss="modal">اغلاق
                    </button>

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- END CONTENT BODY -->
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.css" rel="stylesheet"
              type="text/css"/>

    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/amcharts.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/serial.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/pie.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/radar.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/light.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/patterns.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amcharts/themes/chalk.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/ammap.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/ammap/maps/js/worldLow.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/amcharts/amstockcharts/amstock.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/fullcalendar/fullcalendar.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/dashboard.js" type="text/javascript"></script>
        <script>

            $(document).ready(function () {
                getTask();
                getBarChart();
                getReminder();
                getSessions()
                $(".applyBtn").on('click', function () {
                    getTask();
                    getReminder();
                    getSessions();
                    getBarChart();
                });
            })

            function getTask() {
                var start_date = $('[name="daterangepicker_start"]').val()
                var end_date = $('[name="daterangepicker_end"]').val()
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
                    'ajax': {
                        "type": "post",
                        "url": "home/task-data",
                        "data": {start_date: start_date, end_date: end_date},
                    },
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'task_desc', name: 'task_desc', orderable: true},
                        {data: 'employee_name', name: 'employee_name', orderable: true},
                        {data: 'statusColor', name: 'statusColor', orderable: true},
                        {data: 'task_date', name: 'task_date', orderable: true},
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
            }

            function getBarChart() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('home/lawsuitBar')}}',
                    data: {},

                    success:

                        function (data) {
                            //alert(data.data[0].type_name);
                            creat_bar_chart(data.data);


                        }

                    ,
                    error: function (err) {

                        console.log(err);
                    }

                })
            }

            function creat_bar_chart(data) {

                var chart = AmCharts.makeChart("dashboard_amchart_3", {
                    "type": "serial",
                    "theme": "light",
                    "pathToImages": App.getGlobalPluginsPath() + "amcharts/amcharts/images/",
                    "autoMargins": true,
                    /*"marginLeft": 30,
                    "marginRight": 8,
                    "marginTop": 10,
                    "marginBottom": 30,*/

                    /*"legend": { //======================== CHECK the legend did NOT APPEAR?????
                      "generateFromData": true //custom property for the plugin
                    },*/
                    "fontFamily": 'Open Sans',
                    "color": '#888',

                    "dataProvider": data, /*[{
                "year": 2009,
                "income": 23.5,
                //"expenses": 18.1
            }, {
                "year": 2010,
                "income": 26.2,
                //"expenses": 22.8
            }, {
                "year": 2011,
                "income": 30.1,
                //"expenses": 23.9
            }, {
                "year": 2012,
                "income": 29.5,
                //"expenses": 25.1
            }, {
                "year": 2013,
                "income": 30.6,
                //"expenses": 27.2,
                //"dashLengthLine": 5
            }, {
                "year": 2014,
                "income": 34.1,
                //"expenses": 29.9,
                //"dashLengthColumn": 5,
                //"alpha": 0.2,
                //"additional": "(projection)"
            }],*/
                    "valueAxes": [{
                        "axisAlpha": 0,
                        "position": "left",
                        'integersOnly': true,
                        "gridColor": "#FFFFFF",
                        "gridAlpha": 0.2,
                        "dashLength": 0,
                        "title": "عدد القضايا",
                        "autoGridCount": false,
                        "gridCount": 5,

                    }],
                    "startDuration": 1,
                    "graphs": [{
                        "alphaField": "alpha",
                        "balloonText": "<span style='font-size:13px;'> [[category]]: <b>[[value]]</b> [[additional]]</span>",
                        "dashLengthField": "dashLengthColumn",
                        "fillAlphas": 1,
                        "title": "النوع",
                        "type": "column",
                        "valueField": "COUNT"	//Name in json
                    }, {
                        "balloonText": "<span style='font-size:13px;'>[[title]] in [[category]]:<b>[[value]]</b> [[additional]]</span>",
                        "bullet": "round",
                        "dashLengthField": "dashLengthLine",
                        "lineThickness": 3,
                        "bulletSize": 7,
                        "bulletBorderAlpha": 1,
                        "bulletColor": "#FFFFFF",
                        "useLineColorForBulletBorder": true,
                        "bulletBorderThickness": 3,
                        "fillAlphas": 0,
                        "lineAlpha": 1,
                        "title": "Expenses",
                        "valueField": "expenses"
                    }],
                    "categoryField": "type_name",	//Name in json
                    "categoryAxis": {
                        "gridPosition": "start",
                        "axisAlpha": 0,
                        "tickLength": 0,
                        "labelRotation": 45		// Label Rotation
                    },
                    "export": {
                        "enabled": true
                    }
                });

                $('#dvChart').closest('.portlet').find('.fullscreen').click(function () {
                    chart.invalidateSize();
                });
            }

            function getReminder() {
                var start_date = $('[name="daterangepicker_start"]').val()
                var end_date = $('[name="daterangepicker_end"]').val()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#reminder_tbl').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#reminder_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })
                $('#reminder_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": "home/reminder-data",
                        "data": {start_date: start_date, end_date: end_date},
                    },
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'event_text', name: 'event_text'},
                        {data: 'emp_name', name: 'emp_name'},
                        {data: 'lawsuit_file_no', name: 'lawsuit_file_no'},
                        {data: 'reminder_date', name: 'reminder_date'},
                        {data: 'reminder_type_desc', name: 'reminder_type_desc'},

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
            }

            function getSessions() {
                var start_date = $('[name="daterangepicker_start"]').val()
                var end_date = $('[name="daterangepicker_end"]').val()
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                $('#session_tbl').DataTable().destroy();
                $.fn.dataTable.ext.errMode = 'none';
                $('#session_tbl').on('error.dt', function (e, settings, techNote, message) {
                    console.log('An error has been reported by DataTables: ', message);
                })
                $('#session_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': {
                        "type": "post",
                        "url": "home/session-data",
                        "data": {start_date: start_date, end_date: end_date},
                    },
                    'columns': [
                            {data: 'num', name: 'num'},
                            {data: 'lawsuit_file_no', name: 'lawsuit_file_no'},
                            {data: 'file_color_desc', name: 'file_color_desc'},
                            {data: 'lawsuit.agent_name', name: 'lawsuit.agent_name'},
                            {data: 'lawsuit.respondent_name', name: 'lawsuit.respondent_name'},
                            {data: 'lawsuit.judge', name: 'lawsuit.judge'},
                            {data: 'lawsuit.court_name', name: 'lawsuit.court_name'},
                            {data: 'session_text', name: 'session_text'},
                            {data: 'session_date', name: 'session_date'},


            ],
                aoColumnDefs: [
                    {bSortable: false, aTargets: ["_all"]}
                ],
                    "language"
            :
                {
                    "aria"
                :
                    {
                        "sortAscending"
                    :
                        ": activate to sort column ascending",
                            "sortDescending"
                    :
                        ": activate to sort column descending"
                    }
                ,
                    "emptyTable"
                :
                    "لايوجد بيانات في الجدول للعرض",
                        "info"
                :
                    "عرض _START_ الى  _END_ من _TOTAL_ سجلات",
                        "infoEmpty"
                :
                    "No records found",
                        "infoFiltered"
                :
                    "(filtered1 from _MAX_ total records)",
                        "lengthMenu"
                :
                    "عرض _MENU_",
                        "search"
                :
                    "بحث:",
                        "zeroRecords"
                :
                    "No matching records found",
                        "paginate"
                :
                    {
                        "previous"
                    :
                        "Prev",
                            "next"
                    :
                        "Next",
                            "last"
                    :
                        "Last",
                            "first"
                    :
                        "First"
                    }
                }
            ,

            })
            }


           /* function show_lawysuit(id) {

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
            }*/

            function show_Reminder(id) {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('reminder-source')}}',
                    data: {id: id},

                    success: function (data) {
                        $('#file_no').html('');
                        $('#reminder_date').val('');
                        $('#reminder_text').html('');
                        $('#comments').html('');
                        if (data.data.file_no != '') {
                            $('#fileDv').css('display', 'block');
                            $('#file_no').html(data.data.file_no);
                        }
                        else {
                            $('#fileDv').css('display', 'none');
                            $('#file_no').html('');
                        }


                        $('#reminder_date').val(data.data.reminder_date);
                        $('#reminder_text').html(data.data.reminder_text);
                        $('#comments').html(data.data.comments);

                    }

                    ,
                    error: function (err) {

                        console.log(err);
                    }

                });
            }

            function show_task(task, date) {
                $('#task_desc').html('');
                $('#task_date').val('')
                $('#task_desc').html(task);
                $('#task_date').val(date)
            }


            function update_status(status, id) {
                // alert('status :'+status+' id: '+id)
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: '{{url('home/update-task-status')}}',
                    data: {id: id, status: status},

                    success: function (data) {
                        // alert(data.html);
                        //  $('#task_td').html('');
                        //  $('#task_td').html(data.html);
                        getTask()
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
