
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
                {{Form::open(['url'=>url('employee/'.$emp->emp_id),'class'=>'form-horizontal','method'=>"post","id"=>'employee_form'])}}

                {{method_field('put')}}
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


                                <input id="national_id" name="national_id" type="text" class="form-control "
                                       placeholder="رقم الهوية" data-id="{{$emp->national_id}}"
                                       value="{{$emp->national_id}}">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">الاسم</label>
                        <div class="col-md-4">
                            <div class="input-icon input-group col-md-12">
                                <i class="icon-user"></i>
                                <input name="name" type="text" class="form-control "
                                       placeholder="الاسم" value="{{$emp->name}}"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">البريد الإلكتروني</label>
                        <div class="col-md-4">
                            <div class="input-icon input-group col-md-12">

                                <i class="fa fa-envelope"></i>

                                <input id="email" name="email" type="email" class="form-control"
                                       placeholder="البريد الإلكتروني"  data-id="{{$emp->email}}" value="{{$emp->email}}"></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label col-md-3">المسمى الوظيفي</label>
                        <div class="col-md-4">
                            {{ Form::select('job_title', $jobs,null, ['class' => 'bs-select form-control hselect'])}}

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
                            <div class="input-icon input-group col-md-12">
                                <i class="icon-home"></i>
                                <input name="address" type="text" class="form-control "
                                       placeholder="العنوان" value="{{$emp->address}}"></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">جوال</label>
                        <div class="col-md-4">
                            <div class="input-icon input-group col-md-12">
                                <i class="fa fa-mobile-phone"></i>
                                <input name="mobile" type="text" class="form-control "
                                       placeholder="جوال" value="{{$emp->mobile}}"></div>
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
    </div>
    @push('css')
        <style>

            .hselect {
                height: 41px !important;
            }
        </style>

    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
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
                            if($('#email').attr("data-id")==value)
                            {
                                return true;
                            }

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
                           if($('#national_id').attr("data-id")==value)
                           {
                               return true;
                           }

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
                                required: true,
                                email: true,
                                uniqueEmail: true
                            },
                            mobile: {
                                required: true,
                                digits: true,

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
                            success1.show();
                            error1.hide();
                            App.scrollTo(success1, -200);
                            setTimeout(function () {
                                employeeSubmit();

                            }, 1000);
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
            /* var employeeFormValidation = function () {
                 var handleValidation = function () {
                     // for more info visit the official plugin documentation:
                     // http://docs.jquery.com/Plugins/Validation

                     var form3 = $('#employee_form');
                     var error3 = $('.alert-danger', form3);
                     var success3 = $('.alert-success', form3);


                     form3.validate({
                         errorElement: 'span', //default input error message container
                         errorClass: 'help-block help-block-error', // default input error message class
                         focusInvalid: false, // do not focus the last invalid input
                         ignore: "", // validate all fields including form hidden input
                         rules: {
                             national_id: {
                                 digits: true,
                                 minlength: 9,
                                 required: true
                             },
                             name: {
                                 minlength: 2,
                                 required: true
                             },
                             email: {
                                 required: true,
                                 email: true
                             },
                             mobile: {
                                 required: true,
                                 digits: true,

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
                                 required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                             },

                             email: {
                                 required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                 email: "الرجاء التأكد من القيمة المدخلة, مثال user@admin.com"
                             },
                             mobile: {
                                 required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                 digits: "الرجاء ادخال ارقام فقط",

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

                         errorPlacement: function (error, element) { // render error placement for each input type
                             if (element.parents('.mt-radio-list') || element.parents('.mt-checkbox-list')) {
                                 if (element.parents('.mt-radio-list')[0]) {
                                     error.appendTo(element.parents('.mt-radio-list')[0]);
                                 }
                                 if (element.parents('.mt-checkbox-list')[0]) {
                                     error.appendTo(element.parents('.mt-checkbox-list')[0]);
                                 }
                             } else if (element.parents('.mt-radio-inline') || element.parents('.mt-checkbox-inline')) {
                                 if (element.parents('.mt-radio-inline')[0]) {
                                     error.appendTo(element.parents('.mt-radio-inline')[0]);
                                 }
                                 if (element.parents('.mt-checkbox-inline')[0]) {
                                     error.appendTo(element.parents('.mt-checkbox-inline')[0]);
                                 }
                             } else if (element.parent(".input-group").size() > 0) {
                                 error.insertAfter(element.parent(".input-group"));
                             } else if (element.attr("data-error-container")) {
                                 error.appendTo(element.attr("data-error-container"));
                             } else {
                                 error.insertAfter(element); // for other inputs, just perform default behavior
                             }
                         },

                         invalidHandler: function (event, validator) { //display error alert on form submit
                             success3.hide();
                             error3.show();
                             App.scrollTo(error3, -200);
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
                             success3.show();
                             error3.hide();
                             App.scrollTo(success3, -200);
                             setTimeout(function () {
                                 employeeSubmit();

                             }, 1000);
                         }

                     });

                     //apply validation on select2 dropdown value change, this only needed for chosen dropdown integration.
                     $('.select2me', form3).change(function () {
                         form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                     });

                     //initialize datepicker

                     $('.date-picker .form-control').change(function () {
                         form3.validate().element($(this)); //revalidate the chosen dropdown value and show error or success message for the input
                     })
                 }
                 return {
                     //main function to initiate the module
                     init: function () {
                         handleValidation();

                     }

                 };
             }();*/

            employeeFormValidation.init();

            function employeeSubmit() {

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
                            if (data.success)
                                window.location.href = '{{url('/employee')}}';


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
        </script>
    @endpush
@stop
