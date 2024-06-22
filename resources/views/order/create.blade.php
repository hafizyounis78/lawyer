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
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>&nbsp;{{$page_title}}&nbsp;-&nbsp;رقم الملف&nbsp;(<label
                        id="file_no">{{$one_lawsuit->file_no}}</label>)
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('order'),'class'=>'form-horizontal','method'=>"post","id"=>"order_form"])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input type="hidden" name="hdn_file_id" id="hdn_file_id" value="{{$one_lawsuit->id}}">
                    <input type="hidden" name="hdn_order_id" id="hdn_order_id" value="{{''}}">
                    <div class="form-group">
                        <label class="control-label col-md-3">وقت وتاريخ الطلب</label>
                        <div class="col-md-6">
                            <div class="input-group date form_datetime" data-date=""
                                 data-date-format="dd/mm/yyyy hh:mm">
                                <input type="text" name="order_date" id="order_date" size="40"
                                       class="form-control" dir="ltr">
                                <span class="input-group-btn">
                                                            <button class="btn default date-reset btn-icon-only" type="button">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                            <button class="btn default date-set " type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">رقم الطلب </label>
                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-star"></i>
                                <input class="form-control" name="order_id" id="order_id" rows="3"></input>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">الطلب</label>
                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="order_text" id="order_text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">ملاحظات</label>
                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="comments"  id="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="form-actions left">
                    <div class="row">
                        <div class="col-md-9">
                            <button type="submit" class="btn  green">حفظ</button>
                            <a href="{{url('/order')}}"
                               class="btn  grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
                {{-- </form>--}}
                {{Form::close()}}

            </div>
        </div>
        <div class="row " id="smsDiv">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="glyphicon-phone font-blue"></i>
                            <span class="caption-subject font-blue bold uppercase">رسائل تذكير SMS</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body form">

                        {{--  <h4>اضافة الموكلين</h4>--}}
                        {{Form::open(['url'=>url('sms'),'class'=>'form-horizontal','role'=>'form','method'=>"post","id"=>"sms_form"])}}
                        {{--<form class="form-inline" role="form">--}}
                        {{--<div class="form-body">--}}
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            تمت عملية الحفظ بنجاح!
                        </div>
                        {{--  <input type="hidden" id="hdn_file_no" name="hdn_file_no" value="{{''}}">--}}
                        <input type="hidden" name="smc_type" id="smc_type" value="2">
                        <input type="hidden" name="refernce_id" id="refernce_id" value="{{''}}">

                        <div class="form-group">
                            <label class="col-md-3 control-label">النص</label>
                            <div class="col-md-4">
                                <div class="input-icon">
                                    <i class="icon-book-open"></i>
                                    <textarea class="form-control" name="sms_text" id="sms_text" rows="3"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">الموكلين
                                <span class="required"> * </span></label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <select id="respondant" name="respondant[]" class="form-control select2-multiple"
                                            multiple>

                                        <option value="">اختر قيمة</option>


                                        <?php

                                        foreach ($agents as $agent) {

                                            echo '<option value="' . $agent->mobile . '">' . $agent->name . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">تاريخ الارسال</label>
                            <div class="col-md-4">
                                <div class="input-group input-medium date date-picker" data-date-format="yyyy-mm-dd" data-date-start-date="+0d">
                                    <input type="text" class="form-control" readonly name="send_date" id="send_date">
                                    <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                                </div>


                            </div>
                        </div>

                        <div class="form-group ">
                            <button type="submit" class="btn blue" id="agent_btn">حفظ</button>
                        </div>
                        {{--</div>--}}
                        {{Form::close()}}
                        {{--  </form>--}}
                        <br>
                        <br>
                        <hr>

                        <div class="table-scrollable" id="tableDv">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    {{--  <th> #</th>--}}
                                    <th> النص</th>
                                    <th> المستلم</th>
                                    <th> تاريخ</th>

                                    {{--   <th>تحكم</th>--}}

                                </tr>
                                </thead>
                                <tbody id="tb_sms">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>

        </div>
        <div class="row " id="reminderDiv">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-red-haze"></i>
                            <span class="caption-subject font-red-haze bold uppercase">التنبيهات</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body form">

                        {{--  <h4>اضافة الموكلين</h4>--}}
                        {{Form::open(['url'=>url('reminder'),'class'=>'form-inline','role'=>'form','method'=>"post","id"=>"reminder_form"])}}
                        {{--<form class="form-inline" role="form">--}}
                        {{--<div class="form-body">--}}
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            تمت عملية الحفظ بنجاح!
                        </div>
                        {{--  <input type="hidden" id="hdn_file_no" name="hdn_file_no" value="{{''}}">--}}

                        <input type="hidden" name="hdn_reminder_id" id="hdn_reminder_id" value="{{''}}">

                        <div class="form-group col-md-3">


                            <div class="input-group date form_datetime">
                                <input type="text" size="16" readonly class="form-control" dir="ltr" name="event_date" id="event_date">
                                <span class="input-group-btn">
                                                            <button class="btn default date-set" type="button">
                                                                <i class="fa fa-calendar"></i>
                                                            </button>
                                                        </span>
                            </div>

                        </div>
                        <div class="form-group  col-md-3">
                            <label for="notification_text" class="control-label col-md-3">النص
                            </label>
                            <div class="input-icon input-group col-md-9">
                                <i class="fa fa-user"></i>
                                <input name="event_text" id="event_text" type="text"
                                       class="form-control"
                                       placeholder="النص">
                            </div>
                        </div>
                        <div class="form-group  col-md-5">
                            <label for="multiple" class="control-label col-md-3">الموظف
                            </label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select id="lawyers" name="lawyers[]" class="form-control select2-multiple"
                                            multiple>

                                        {{-- <option value="">اختر قيمة</option>--}}


                                        <?php

                                        foreach ($lawyers as $lawyer) {

                                            echo '<option value="' . $lawyer->emp_id . '">' . $lawyer->name . '</option>';
                                        }

                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-1">
                            <button type="submit" class="btn blue" id="agent_btn">اضافة</button>
                        </div>
                        {{--</div>--}}
                        {{Form::close()}}
                        {{--  </form>--}}
                        <br>
                        <br>
                        <hr>

                        <div class="table-scrollable" id="tableDv">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    {{--  <th> #</th>--}}
                                    <th> تاريخ</th>
                                    <th> التنبية</th>
                                    <th> المحامي</th>
                                    <th>تحكم</th>

                                </tr>
                                </thead>
                                <tbody id="tb_reminder">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>

        </div>
        <!-- END FORM-->
        <br>

    </div>


    @push('css')
        <style>
            .date-set,.date-reset{
                display: none !important;

            }
            .btn:not(.md-skip):not(.bs-select-all):not(.bs-deselect-all).btn-icon-only
            {
                position: initial;
                margin-right: 1px;
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
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet"
              type="text/css"/>

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
        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js"
                type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
        <script>

            /*  $(function() {
                  $('#form_datetime').datepicker({ dateFormat: 'yyy-dd-mm HH:MM:ss' }).val();
              });*/
            //  $("#datepicker").datepicker("option", "dateFormat", "yy-mm-dd ");
        </script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->

        <script type="text/javascript">
            $(".form_datetime").datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            });
        </script>
        <script>

            var orderFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#order_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input
                        messages: {
                            select_multi: {
                                maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            }
                        },
                        rules: {

                            order_date: {
                                date: true,
                                required: true

                            },
                            order_text: {
                                required: true

                            }

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            order_date: {
                                date:"يرجى التأكد من القيمة المدخلة",
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            order_text: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            }
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit
                            success1.hide();
                            error1.show();
                            App.scrollTo(error1, -200);
                        },

                        errorPlacement: function (error, element) { // render error placement for each input type
                            var cont = $(element).parent('.input-group');
                            if (cont) {
                                cont.after(error);
                            } else {
                                element.after(error);
                            }
                        },

                        highlight: function (element) { // hightlight error inputs

                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        unhighlight: function (element) { // revert the change done by hightlight
                            $(element)
                                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label
                                .closest('.form-group').removeClass('has-error'); // set success class to the control group
                        },

                        submitHandler: function (form) {


                            orderSubmit();


                        }
                    });


                }


                return {
                    //main function to initiate the module
                    init: function () {


                        handleValidation1();


                    }

                };

            }();

            orderFormValidation.init();

            function orderSubmit() {
                var form1 = $('#order_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#order_form').attr('action');
                var hdn_file_id = $('#hdn_file_id').val();
                var formData = new FormData($('#order_form')[0]);
                formData.append('hdn_file_id', hdn_file_id),


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,

                        processData:
                            false,
                        contentType:
                            false,
                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    $('#hdn_order_id').val(data.order_id);
                                    $('#refernce_id').val(data.order_id);
                                    /*  $('#prcd_date').val('');
                                      $('#prcd_text').val('');
                                      $('#comments').val('');
                                      $('#sms_text').val('');
  */
                                    $('#reminderDiv').css('display', 'block');

                                    var showdiv = $('#agent_btn')
                                    App.scrollTo(showdiv, -200);

                                }
                                else {
                                    success.hide();
                                    error.show();
                                    App.scrollTo(error, -200);
                                    error.fadeOut(2000);
                                }
                                //  window.location.href = '{{url('/user')}}';


                            }

                        ,
                        error: function (err) {

                            console.log(err);
                        }
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }
            //*************************************************
            var smsFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#sms_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input
                        messages: {
                            select_multi: {
                                maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            }
                        },
                        rules: {

                            sms_text: {
                                required: true
                            }
                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            sms_text: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال نص الرسالة",

                            }
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit
                            success1.hide();
                            error1.show();
                            App.scrollTo(error1, -200);
                        },

                        errorPlacement: function (error, element) { // render error placement for each input type
                            var cont = $(element).parent('.input-group');
                            if (cont) {
                                cont.after(error);
                            } else {
                                element.after(error);
                            }
                        },

                        highlight: function (element) { // hightlight error inputs

                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        unhighlight: function (element) { // revert the change done by hightlight
                            $(element)
                                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label
                                .closest('.form-group').removeClass('has-error'); // set success class to the control group
                        },

                        submitHandler: function (form) {


                            smsSubmit();


                        }
                    });


                }


                return {
                    //main function to initiate the module
                    init: function () {


                        handleValidation1();


                    }

                };

            }();


            smsFormValidation.init();

            function smsSubmit() {
                var form1 = $('#sms_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#sms_form').attr('action');
                var hdn_file_id = $('#hdn_file_id').val();
                var refernce_id = $('#refernce_id').val();
                var formData = new FormData($('#sms_form')[0]);
                formData.append('hdn_file_id', hdn_file_id);
                formData.append('refernce_id', refernce_id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,

                        processData:
                            false,
                        contentType:
                            false,
                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    $('#sms_text').val('');

                                    $("#tb_sms").html(data.table);
                                    /*    var showdiv = $('#agent_btn')
                                        App.scrollTo(showdiv, -200);
                                        $('#respondentsDiv').css('display', 'block');*/
                                }
                                else {
                                    success.hide();
                                    error.show();
                                    App.scrollTo(error, -200);
                                    error.fadeOut(2000);
                                }
                            }

                        ,
                        error: function (err) {

                            console.log(err);
                        }

                    }
                )
                //   });
            }


            //*************************************************
            var reminderFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#reminder_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input
                        messages: {
                            select_multi: {
                                maxlength: jQuery.validator.format("Max {0} items allowed for selection"),
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            }
                        },
                        rules: {

                            event_date: {
                                date: true,
                                required: true

                            },
                            event_text: {
                                required: true

                            },
                            lawyers: {
                                required: true,
                                minlength: 1
                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            event_date: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            event_text: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            lawyers: {
                                required: "يرجى اختيار قيمة واحدة على الاقل",
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            },
                        },

                        invalidHandler: function (event, validator) { //display error alert on form submit
                            success1.hide();
                            error1.show();
                            App.scrollTo(error1, -200);
                        },

                        errorPlacement: function (error, element) { // render error placement for each input type
                            var cont = $(element).parent('.input-group');
                            if (cont) {
                                cont.after(error);
                            } else {
                                element.after(error);
                            }
                        },

                        highlight: function (element) { // hightlight error inputs

                            $(element)
                                .closest('.form-group').addClass('has-error'); // set error class to the control group
                        },

                        unhighlight: function (element) { // revert the change done by hightlight
                            $(element)
                                .closest('.form-group').removeClass('has-error'); // set error class to the control group
                        },

                        success: function (label) {
                            label
                                .closest('.form-group').removeClass('has-error'); // set success class to the control group
                        },

                        submitHandler: function (form) {


                            reminderSubmit();


                        }
                    });


                }


                return {
                    //main function to initiate the module
                    init: function () {


                        handleValidation1();


                    }

                };

            }();


            reminderFormValidation.init();

            function reminderSubmit() {
                var form1 = $('#reminder_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#reminder_form').attr('action');
                var hdn_file_id = $('#hdn_file_id').val();
                var hdn_order_id = $('#hdn_order_id').val();
                var formData = new FormData($('#reminder_form')[0]);
                formData.append('hdn_file_id', hdn_file_id),
                    formData.append('hdn_event_id', hdn_order_id),
                    formData.append('reminder_type', 2),

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,

                        processData:
                            false,
                        contentType:
                            false,
                        success:

                            function (data) {
                                if (data.success) {

                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    $('#hdn_reminder_id').val('');
                                    $('#event_text').val('');
                                    $('#event_date').val('');
                                    $('#lawyers').val(0);
                                    $("#lawyers option:selected").removeAttr("selected");
                                    $('#lawyers').val(null).trigger('change');
                                    //  $('#tableDv').css('display', 'block');
                                    $("#tb_reminder").html(data.table);
                                    /*    var showdiv = $('#agent_btn')
                                        App.scrollTo(showdiv, -200);
                                        $('#respondentsDiv').css('display', 'block');*/
                                }
                                else {
                                    success.hide();
                                    error.show();
                                    App.scrollTo(error, -200);
                                    error.fadeOut(2000);
                                }
                                //  window.location.href = '{{url('/user')}}';


                            }

                        ,
                        error: function (err) {

                            console.log(err);
                        }
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }

            function updateReminder(id,emp_id,event_date,event_text) {

                $('.form_datetime').datetimepicker({
                    date: event_date
                });
                $('.form_datetime').datetimepicker('update')
                //( "setDate", event_date);
                $('#event_date').val(event_date);
                $('#event_text').val(event_text);
                $('#lawyers').val(emp_id);

                $('#lawyers').trigger('change')

                $('#hdn_reminder_id').val(id);

            }

            function deleteReminder(id, element) {

                var x = '';
                var r = confirm('هل انت متأكد من عملية الحذف');
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
                        url: '{{url('reminder-delete')}}',

                        data: {id: id},
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);
                        },
                        beforeSend: function () {
                        },
                        complete: function () {
                        },
                        success: function (data) {
                            if (data.success == true) {

                                element.closest('tr').remove();
                                // element.parent('tr').remove();

                            }


                        }
                    });//END $.ajax
                }
            }

            //********************************************************************

        </script>
    @endpush
@stop
