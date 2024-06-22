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
                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    {{--  <input type="hidden" id="hdn_file_no" name="hdn_file_no" value="{{''}}">--}}
                    <input type="hidden" name="smc_type" id="smc_type" value="4">
                    <input type="hidden" name="refernce_id" id="refernce_id" value="{{''}}">

                    <div class="form-group">
                        <label class="col-md-3 control-label">النص</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="icon-book-open"></i>
                                <textarea class="form-control" name="sms_text" id="sms_text" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">جوال</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="fa fa-mobile-phone"></i>
                                <input name="mobile" type="text" class="form-control "
                                       placeholder="جوال" value="{{isset($emp->mobile)}}"></div>
                        </div>

                    </div>
                    <div class="form-group ">

                        <div class="col-md-3">
                            <button type="submit" class="btn blue" id="agent_btn">ارسال</button>
                        </div>
                    </div>
                </div>
                {{--</div>--}}
                {{Form::close()}}
                {{--  </form>--}}

            </div>
        </div>


    </div>
    @push('css')

        <link href="{{url('')}}/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
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
        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
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
                            },
                            mobile: {
                                number: true,
                                required: true
                            }
                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            sms_text: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال نص الرسالة",

                            },
                            mobile: {
                                number: 'تأكد من القيمة المدخلة ارقام فقط',
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
                App.blockUI();
                var action = $('#sms_form').attr('action');
                //    var hdn_file_id = $('#hdn_file_id').val();
                //     var refernce_id = $('#refernce_id').val();
                var formData = new FormData($('#sms_form')[0]);
                //   formData.append('hdn_file_id', hdn_file_id);
                //  formData.append('refernce_id', refernce_id);

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
                                    App.unblockUI();
                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    $('#sms_text').val('');
                                    $('#mobile').val('');

                                    //$("#tb_sms").html(data.table);
                                    /*    var showdiv = $('#agent_btn')
                                        App.scrollTo(showdiv, -200);
                                        $('#respondentsDiv').css('display', 'block');*/
                                } else {
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

        </script>

    @endpush
@stop
