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
                    <i class="fa fa-gift"></i>{{$portlet_title}}</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>url('setting/s1-save'),'class'=>'form-horizontal','method'=>"post","id"=>"setting_form"])}}
                <input type="hidden" id="hdn_table_id" name="hdn_table_id" value="{{''}}">
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
                        <label class="col-md-3 control-label">الوصف</label>
                        <div class="col-md-3">
                            <div class="input-icon input-group col-md-12 ">
                                <i class="fa fa-paw"></i>
                                <input id="desc" name="desc" type="text" class="form-control "
                                       placeholder="الوصف" value=""></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label">اللون</label>
                        <div class="col-md-3">
                            <div class="input-icon input-group col-md-12 ">
                                <i class="fa fa-paint-brush"></i>
                                <input type="color" id="file_color" name="file_color" class="form-control "
                                     ></div>

                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class=" col-md-9">
                            <button type="submit" class="btn  green">حفظ</button>
                            <button type="button" onclick="clearForm()" class="btn  red-intense">الغاء</button>
                            <a href="{{url('/')}}" class="btn  grey-salsa btn-outline">عودة</a>

                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>

        <div class="portlet box yellow-casablanca">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>جدول القيم
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <table class="table table-striped table-bordered table-hover  order-column" id="setting_tbl">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> كود</th>
                            <th> الوصف</th>
                            <th> اللون</th>
                            <th>  كود اللون</th>
                            <th>تحكم</th>

                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @push('css')
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{url('')}}/assets/global/plugins/bootstrap-colorpicker/css/colorpicker.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/jquery-minicolors/jquery.minicolors.css" rel="stylesheet"
              type="text/css"/>
        <!-- END PAGE LEVEL PLUGINS -->
    @endpush
    @push('js')

        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('')}}/assets/global/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/jquery-minicolors/jquery.minicolors.min.js"
                type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        {{--<script src="{{url('')}}/assets/pages/scripts/components-color-pickers.min.js"
                type="text/javascript"></script>--}}
       {{-- <script src="https://kendo.cdn.telerik.com/2018.2.620/js/kendo.all.min.js"></script>--}}

        <script>
            $(document).ready(function () {
                $('#setting_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/s1-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'id', name: 'id'},
                        {data: 'desc', name: 'desc'},
                        {
                            data: 'file_color', name: 'file_color',

                            render: function (data, type, full, meta) {
                                return '<div style="background-color:' + data + '">&nbsp;</div>';

                            }
                        },
                        {data: 'file_color', name: 'file_color'},
                        {data: 'action', name: 'action'}
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
                /*$('#picker').kendoColorPicker({
                    palette: 'basic'
                });*/

            })

        </script>
        <script src="{{url('')}}/assets/global/plugins/jquery-validation/js/jquery.validate.min.js"
                type="text/javascript"></script>
        <script type="text/javascript">

            var settingFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#setting_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique email


                    form1.validate({
                        errorElement: 'span', //default input error message container
                        errorClass: 'help-block help-block-error', // default input error message class
                        focusInvalid: false, // do not focus the last invalid input
                        ignore: "",  // validate all fields including form hidden input

                        rules: {

                            desc: {
                                required: true,

                            },
                            file_color: {
                                required: true,

                            }
                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            desc: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },
                            file_color: {
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

                            settingSubmit();


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


            settingFormValidation.init();

            function settingSubmit() {

                var form1 = $('#setting_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#setting_form').attr('action');

                var formData = new FormData($('#setting_form')[0]);

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
                                    window.location.href = '{{url('setting/s1')}}';

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

            function settingDelete(id) {

                var form1 = $('#setting_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var x = '';
                var r = confirm('سيتم حذف القيمة ,هل انت متاكد من ذلك؟');
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
                            url: '{{url('setting/s1-delete')}}',
                            data: {id: id},

                            success:

                                function (data) {
                                    if (data.success) {

                                        success.show();
                                        error.hide();
                                        App.scrollTo(success, -200);
                                        success.fadeOut(2000);
                                        window.location.href = '{{url('setting/s1')}}';

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
                }
                    //   });
                }

                function fillForm(id, desc, file_color) {
                    $('#hdn_table_id').val(id);
                    $('#desc').val(desc);
                    $('#file_color').minicolors('value', file_color);//val(file_color);
                    $("#file_color").trigger('change');
                    var itemUp = $('#desc');
                    App.scrollTo(itemUp, -200);


                }

                function clearForm() {
                    $('#hdn_table_id').val('');
                    $('#desc').val('');
                    $('#file_color').val('');

                }

        </script>
    @endpush
@stop