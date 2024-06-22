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
        <div class="portlet box red-haze">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>{{$page_title}}</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('reminder-general'),'class'=>'form-horizontal','method'=>"post","id"=>"reminder_form"])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">وقت وتاريخ التنبيه
                            <span class="required"> * </span></label>
                        <div class="col-md-6">
                            <div class="input-group date form_datetime" data-date=""
                                 data-date-format="dd/mm/yyyy hh:mm:ss">
                                <input type="text" name="reminder_date" id="reminder_date" size="40"  class="form-control" dir="ltr">
                                <span class="input-group-btn">
                                    <button class="btn default date-reset" type="button">
                                        <i class="fa fa-times"></i>
                                    </button>
                                    <button class="btn default date-set" type="button">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">النص
                            <span class="required"> * </span></label>
                        <div class="col-md-6">
                            <div class="input-icon">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="event_text" id="event_text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">


                        <div class="form-group">
                            <label for="multiple" class="control-label col-md-3">الموظف
                                <span class="required"> * </span></label>
                            <div class="col-md-6">
                                <select id="lawyers" name="lawyers[]" class="form-control select2-multiple" multiple>
                                    <option value="">اختر قيمة</option>
                                    <?php
                                    foreach ($lawyers as $lawyer) {

                                        echo '<option value="' . $lawyer->emp_id . '">' . $lawyer->name . '</option>';
                                    }

                                    ?>
                                    </optgroup>
                                </select>
                            </div>
                        </div>


                    </div>

                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class="col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                            <a href="{{url('/sms')}}" class="btn  grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
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
        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css" />
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
    @endpush
    @push('js')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- END PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
        <script type="text/javascript">
            $(".form_datetime").datetimepicker({
                format: 'yyyy-mm-dd hh:ii',
                autoclose: true,
                todayBtn: true,
                pickerPosition: "bottom-left"
            });

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

                            reminder_date: {
                                required: true,

                            },
                            event_text: {
                                required: true,
                            },
                            lawyers: {
                                required: true,
                                minlength: 1
                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            reminder_date: {
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

                var formData = new FormData($('#reminder_form')[0]);

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

                                    window.location.href = '{{url('/sms')}}';
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
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }
        </script>

    @endpush
@stop
