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
                {{Form::open(['url'=>url('session'),'class'=>'form-horizontal','method'=>"post","id"=>"session_form"])}}

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
                    <input type="hidden" name="hdn_session_id" id="hdn_session_id" value="{{''}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label">الإجراءات
                        </label>
                        <div class="col-md-4 ">
                            <div class="input-group">
                                <select id="prcd_id" name="prcd_id" class="form-control select2 ">

                                    <option value="">اختر قيمة</option>


                                    <?php

                                    foreach ($prcds as $prcd) {

                                        echo '<option value="' . $prcd->id . '">'. $prcd->prcd_date.' - '. $prcd->prcd_text . '</option>';
                                    }

                                    ?>


                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3"> تاريخ الجلسة</label>
                        <div class="col-md-4">
                            <div class="input-group  date date-picker" data-date-format="yyyy-mm-dd" >
                                <input type="text" class="form-control" readonly name="session_date" id="session_date">
                                <span class="input-group-btn">
                                        <button class="btn default" type="button">
                                            <i class="fa fa-calendar"></i>
                                        </button>
                                    </span>
                            </div>


                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">تفاصيل الجلسة</label>
                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="session_text" id="session_text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">ملاحظات</label>
                        <div class="col-md-4">
                            <div class="input-icon">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="comments" id="comments" rows="3"></textarea>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="form-actions left">
                    <div class="row">
                        <div class="col-md-9">
                            <button type="submit" class="btn  green">حفظ</button>
                            <a href="{{url('/session')}}"
                               class="btn  grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
                {{-- </form>--}}
                {{Form::close()}}

            </div>
        </div>

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


        </script>
        <!-- BEGIN PAGE LEVEL PLUGINS -->


        <script>

            var sessionFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#session_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
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

                            session_date: {
                                date: true,
                                required: true

                            },
                            session_text: {
                                required: true

                            }

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            session_date: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

                            },
                            session_text: {
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


                            sessionSubmit();


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

            sessionFormValidation.init();

            function sessionSubmit() {
                var form1 = $('#session_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#session_form').attr('action');
                var hdn_file_id = $('#hdn_file_id').val();
                var formData = new FormData($('#session_form')[0]);
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

                                    $('#hdn_session_id').val(data.session_id);
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
            }

        </script>
    @endpush
@stop
