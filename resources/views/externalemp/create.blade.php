
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
        <div class="portlet box blue">
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
                {{Form::open(['url'=>url('externalemp'),'class'=>'form-horizontal','method'=>"post","id"=>'employee_form'])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input type="hidden" id="id" name="id" value="{{''}}">
                    <div class="form-group">

                        <label class="col-md-3 control-label">رقم الهوية</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">

                                <i class="fa fa-cog"></i>


                                <input id="national_id" name="national_id" type="text" class="form-control "
                                       placeholder="رقم الهوية" value="">

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">الاسم</label>
                        <div class="col-md-4">
                            <div class="input-icon input-group col-md-12">
                                <i class="icon-user"></i>
                                <input id="name"  name="name" type="text" class="form-control"
                                       placeholder="الاسم" value=""></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">البريد الإلكتروني</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">

                                <i class="fa fa-envelope"></i>

                                <input id="email" name="email" type="email" class="form-control "
                                       placeholder="البريد الإلكتروني" value=""></div>
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="col-md-3 control-label">جوال</label>
                        <div class="col-md-4">
                            <div class="input-icon  input-group col-md-12">
                                <i class="fa fa-mobile-phone"></i>
                                <input id="mobile" name="mobile" type="text" class="form-control "
                                       placeholder="جوال" value="{{isset($emp->mobile)}}"></div>
                        </div>
                    </div>


                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class=" col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                            <a href="{{url('/setting')}}" class="btn  grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
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
                            <span class="caption-subject bold uppercase"> {{$table_title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">

                        <table class="table table-striped table-bordered table-hover table-checkable order-column" id="external_tbl">
                            <thead>
                            <tr>
                                <th> # </th>
                                <th> رقم الهوية </th>
                                <th> الاسم </th>
                                <th> البريد الإلكتروني </th>
                                <th> جوال </th>
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
    @push('css')
        <style>

            .hselect {
                height: 41px !important;
            }
        </style>

    @endpush
    @push('js')
        <script>
            $(document).ready(function () {

                $('#external_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/externalemp-data')}}',
                    /*id`, `name`, `email`, ``, ``, `gender`, `address`, `mobile`, `image`, `user_type`, ``, `company_id`, `supervisor_id`, ``*/
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'national_id', name: 'national_id'},
                        {data: 'name', name: 'name'},
                        {data: 'email', name: 'email'},
                        {data: 'mobile', name: 'mobile'},
                        {data:'action', name: 'action'},],
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
                            "previous":"Prev",
                            "next": "Next",
                            "last": "Last",
                            "first": "First"
                        }
                    },

                })
                /*$('#external_tbl tbody').on( 'click', 'button', function () {
                  alert('hhhh')
                    //  var data = table.row( $(this).parents('tr') ).data();
                    alert( data[0] +"'s salary is: "+ data[ 5 ] );
                } );*/

            })
        </script>

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

                            $.ajax({
                                type: "POST",
                                url: '{{url('externalemp/availabileEmail')}}',

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

                            $.ajax({
                                type: "POST",
                                url: '{{url('externalemp/availabileNationalId')}}',

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
                                window.location.href = '{{url('/externalemp')}}';


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
            function edit_row(id,name,email,national_id,mobile)
            {
               //alert('id='+id+' name = '+name+' email ='+email +' national_id='+national_id+' mobile= '+mobile);

                $('#id').val(id);
                $('#name').val(name);
                $('#email').val(email);
                $('#national_id').val(national_id);
                $('#mobile').val(mobile);
                var up=$('#name')
                App.scrollTo(up, -200);
            }
        </script>
    @endpush
@stop
