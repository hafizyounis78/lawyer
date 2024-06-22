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
                    <i class="fa fa-gift"></i>{{$page_title}}</div>
                {{--<div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                    <a href="#portlet-config" data-toggle="modal" class="config"> </a>
                    <a href="javascript:;" class="reload"> </a>
                    <a href="javascript:;" class="remove"> </a>
                </div>--}}
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('employee'),'class'=>'form-horizontal','method'=>"post","id"=>'employee_form'])}}

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

                        <label class="col-md-3 control-label">رقم الهوية</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">

                                <i class="fa fa-cog"></i>


                                <input name="national_id" type="text" class="form-control "
                                       placeholder="رقم الهوية" value="">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">الاسم</label>
                        <div class="col-md-4">
                            <div class="input-icon input-group col-md-12">
                                <i class="icon-user"></i>
                                <input name="name" type="text" class="form-control"
                                       placeholder="الاسم" value=""></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">البريد الإلكتروني</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">

                                <i class="fa fa-envelope"></i>

                                <input name="email" type="email" class="form-control "
                                       placeholder="البريد الإلكتروني" value=""></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">المسمى الوظيفي</label>
                        <div class="col-md-4">
                            {{ Form::select('job_title', $jobs,null, ['class' => 'bs-select form-control hselect'])}}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ بداية </label>
                        <div class="col-md-4">
                            <input name="start_date" class="form-control form-control-inline  date-picker" size="16"
                                   type="text" value="" data-date-format="yyyy-mm-dd"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">تاريخ نهاية </label>
                        <div class="col-md-4">
                            <input name="end_date" class="form-control form-control-inline  date-picker" size="16"
                                   type="text" value="" data-date-format="yyyy-mm-dd"/>

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">المحافظة</label>
                        <div class="col-md-4">
                            {{ Form::select('districts_id',$districts,null, ['class' => 'bs-select form-control hselect'])}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">العنوان</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="icon-home"></i>
                                <input name="address" type="text" class="form-control "
                                       placeholder="العنوان" value="{{isset($emp->address)}}"></div>
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


                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class=" col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                            <a href="{{url('/employee')}}" class="btn  grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">تحميل المستندات </h3>
                    </div>
                    {{Form::open(['url'=>url('employee/uploadFile'),'class'=>'form-horizontal','method'=>"post",'files' => true,"id"=>"upload_form",""])}}

                    <div class="form-body">
                        <div class="alert alert-danger display-hide">
                            <button class="close" data-close="alert"></button>
                            يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                        </div>
                        <div class="alert alert-success display-hide">
                            <button class="close" data-close="alert"></button>
                            تمت عملية الحفظ بنجاح!
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <h4>{{$errors->first()}}</h4>
                            </div>
                        @endif
                        <input type="hidden" id="hdn_emp_id" name="hdn_emp_id" value="{{''}}"/>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">اسم الملف</label>
                                        <div class="col-md-6">
                                            <div class="input-icon">
                                                <i class="fa fa-file-archive-o"></i>
                                                <input name="file_title" id="file_title" type="text"
                                                       class="form-control input"
                                                       placeholder="اسم الملف" value=""></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="control-label col-md-3">الملف </label>
                                        <div class="col-md-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                        <span class="btn green btn-file">
                                                            <span class="fileinput-new">استعراض </span>
                                                            <span class="fileinput-exists"> تغيير </span>
                                                            <input type="file" name="file_name" id="file_name"> </span>
                                                <span class="fileinput-filename"> </span> &nbsp;
                                                <a href="javascript:;" class="close fileinput-exists"
                                                   data-dismiss="fileinput"> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn blue">حفظ</button>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- </form>--}}
                    {{Form::close()}}

                </div>
            </div>

        </div>
        <div class="portlet light portlet-fit ">

            <div class="portlet-body">
                <div class="table-scrollable">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            {{--  <th> #</th>--}}
                            <th> #</th>
                            <th>اسم الملف</th>
                            <th>تاريخ</th>
                            <th>تحكم</th>
                        </tr>
                        </thead>
                        <tbody id="tb_files">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('css')

        <link href="{{url('')}}/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/clockface/css/clockface.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css"
              rel="stylesheet"
              type="text/css"/>


        <link href="{{url('')}}/assets/global/plugins/fancybox/source/jquery.fancybox.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css"
              rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/css/jquery.fileupload.css"
              rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-file-upload/css/jquery.fileupload-ui.css"
              rel="stylesheet"
              type="text/css"/>
        <style>

            .hselect {
                height: 41px !important;
            }

            .datepicker-dropdown {
                width: 220px;
            }
        </style>

    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/moment.min.js" type="text/javascript"></script>

        <script src="{{url('')}}/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"
                type="text/javascript"></script>

        <script src="{{url('')}}/assets/global/plugins/clockface/js/clockface.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-date-time-pickers.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>

        <script src="{{url('/')}}/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js"
                type="text/javascript"></script>

        <!-- END PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/jquery.ui.widget.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/tmpl.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/load-image.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/vendor/canvas-to-blob.min.js"
                type="text/javascript"></script>
        <script
            src="{{url('')}}/assets/global/plugins/jquery-file-upload/blueimp-gallery/jquery.blueimp-gallery.min.js"
            type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.iframe-transport.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-process.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-image.js"
                type="text/javascript"></script>

        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-validate.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-file-upload/js/jquery.fileupload-ui.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/form-fileupload.js" type="text/javascript"></script>
        <script>
            var employeeFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#employee_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email
                    var response = true;
                    $.validator.addMethod(
                        "uniqueEmail",
                        function (value, element) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: '{{url('employee/availabileEmail')}}',

                                data: {email: value},
                                error: function (xhr, status, error) {
                                    alert(xhr.responseText);
                                },
                                beforeSend: function () {
                                },
                                complete: function () {
                                },
                                success: function (data) {
                                    if (data.success == true)
                                        response = false;
                                    else
                                        response = true;
                                }
                            });//END $.ajax
                            return response;
                        },
                        "هذا البريد الإلكتروني غير متوفر,يرجى التأكد من القيمة المدخلة"
                    );
                    var response2 = true;
                    $.validator.addMethod(
                        "uniqueNationalId",
                        function (value, element) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            if (value != '')
                                $.ajax({
                                    type: "POST",
                                    url: '{{url('employee/availabileNationalId')}}',

                                    data: {id: value},
                                    error: function (xhr, status, error) {
                                        alert(xhr.responseText);
                                    },
                                    beforeSend: function () {
                                    },
                                    complete: function () {
                                    },
                                    success: function (data) {
                                        if (data.success == true)
                                            response2 = false;
                                        else
                                            response2 = true;
                                    }
                                });//END $.ajax
                            return response2;
                        },
                        "رقم الهوية موجود مسبقاً ,يرجى التأكد من القيم المدخلة"
                    );
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
                            national_id: {
                                digits: true,
                                minlength: 9,
                                maxlength: 9,
                                required: true,
                                uniqueNationalId: true
                            },
                            name: {
                                minlength: 2,
                                required: true
                            },
                            email: {
                                //     required: true,
                                email: true,
                                uniqueEmail: true
                            },
                            mobile: {
                                required: true,
                                digits: true,
                                maxlength: 10

                            },
                            job_title: {
                                required: true
                            },
                            districts_id: {
                                required: true
                            },
                            address: {

                                required: true
                            }

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            name: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                minlength: "القيمة المدخلة غير مناسبة ,الرجاء ادخال قيمة أكبر من حرفني"
                            },
                            national_id: {
                                digits: "الرجاء ادخال ارقام فقط",
                                minlength: "القيمة المدخلة غير مناسبة ,الرجاء ادخال 9 ارقام",
                                maxlength: "القيمة المدخلة غير مناسبة ,الرجاء ادخال 9 ارقام",
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                uniqueNationalId: "رقم الهوية موجود مسبقاً ,يرجى التأكد من القيم المدخلة"
                            },

                            email: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                email: "الرجاء التأكد من القيمة المدخلة, مثال user@admin.com"
                            },
                            mobile: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: 'تأكد من الرقم المدخل, 10 ارقام فقط '

                            },
                            job_title: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",
                            },
                            districts_id: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",
                            },
                            address: {

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

                            employeeSubmit();


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


            employeeFormValidation.init();

            function employeeSubmit() {

                var form1 = $('#employee_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#employee_form').attr('action');

                var formData = new FormData($('#employee_form')[0]);
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            if (data.success) {

                                success.show();
                                error.hide();
                                App.scrollTo(success, -200);
                                success.fadeOut(2000);
                                $('#hdn_emp_id').val(data.emp_id);
                                //  window.location.href = '{{url('/employee')}}';
                            } else {
                                success.hide();
                                error.show();
                                App.scrollTo(error, -200);
                                error.fadeOut(2000);
                            }


                        },
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

            var uploadfileFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#upload_form');
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
                            file_title: {
                                required: true
                            },
                            file_link: {
                                required: true,
                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            file_title: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            file_link: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",

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

                            fileUploadSubmit();

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
            uploadfileFormValidation.init();

            function fileUploadSubmit() {


                var action = $('#upload_form').attr('action');
                //    var hdn_file_no = $('#hdn_file_no').val();
                var formData = new FormData($('#upload_form')[0]);
                //    formData.append('hdn_file_no', hdn_file_no),
                App.blockUI({
                    target: '#upload_form',
                    boxed: true,
                    message: 'جاري تحميل الملف ,يرجى الإنتظار...'
                });
                $.ajax({
                        url: action,
                        type: 'POST',
                        dataType: 'json',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (data) {

                            if (data.success) {
                                App.unblockUI('#upload_form');
                                $('#tb_files').html(data.table);
                                $('#file_title').val('');
                                $('#file_name').val('');
                                $("#upload_form")[0].reset();
                            }
                        },
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

            function deleteFile(id, element) {

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
                        url: '{{url('employee/file-delete')}}',

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
        </script>
    @endpush
@stop
