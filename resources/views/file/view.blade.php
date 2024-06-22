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
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase">{{$page_title}}</span>
                        </div>

                    </div>
                    @if (in_array(63, auth()->user()->user_per))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">تحميل المستندات </h3>
                                    </div>
                                    {{Form::open(['url'=>url('file/uploadFile'),'class'=>'form-horizontal','method'=>"post",'files' => true,"id"=>"upload_form",""])}}

                                    <div class="form-body">
                                        <div class="alert alert-danger display-hide">
                                            <button class="close" data-close="alert"></button>
                                            يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                                        </div>
                                        <div class="alert alert-success display-hide">
                                            <button class="close" data-close="alert"></button>
                                            تمت عملية الحفظ بنجاح!
                                        </div>
                                        <div class="panel-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">اسم الملف</label>
                                                        <div class="col-md-9">
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
                                                        <label class="col-md-6 control-label">نوع الملف
                                                            <span class="required"> * </span></label>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <select id="file_type" name="file_type"
                                                                        class="form-control select2">
                                                                    <option value="">اختر قيمة</option>


                                                                    <?php

                                                                    foreach ($FileTypes as $FileType) {

                                                                        echo '<option value="' . $FileType->id . '">' . $FileType->desc . '</option>';
                                                                    }

                                                                    ?>


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">

                                                    <div class="form-group">
                                                        <label class="control-label col-md-3">الملف </label>
                                                        <div class="col-md-9">
                                                            <div class="fileinput fileinput-new"
                                                                 data-provides="fileinput">
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
                                            </div>
                                            <div class="row">

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">ملاحظات</label>
                                                        <div class="col-md-9">
                                                            <div class="input-icon">
                                                                <i class="icon-book-open"></i>
                                                                <textarea class="form-control" name="file_note"
                                                                          id="file_note" rows="3"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-md-6 control-label">حركة الملف
                                                            <span class="required"> * </span></label>
                                                        <div class="col-md-5">
                                                            <div class="input-group">
                                                                <select id="file_location" name="file_location"
                                                                        class="form-control select2">
                                                                    <option value="">اختر قيمة</option>


                                                                    <?php

                                                                    foreach ($FileLocations as $FileLocation) {

                                                                        echo '<option value="' . $FileLocation->id . '">' . $FileLocation->desc . '</option>';
                                                                    }

                                                                    ?>


                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="control-label col-md-4">مشاركة الملف </label>
                                                        <div class="col-md-5">
                                                            <div class="mt-checkbox-inline">
                                                                <label class="mt-checkbox">
                                                                    <input type="checkbox" id="file_share"
                                                                           name="file_share" value="1">
                                                                    <span></span>
                                                                </label>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
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
                    @endif
                    <div class="portlet light portlet-fit ">

                        <div class="portlet-body">
                            <div class="table-scrollable">
                                <table class="table table-bordered table-hover" id="files_tbl">
                                    <thead>
                                    <tr>
                                        {{--  <th> #</th>--}}
                                        <th> #</th>
                                        <th>اسم الملف</th>
                                        <th>نوع الملف</th>
                                        <th>مكان الملف</th>
                                        <th>ملاحظات</th>
                                        <th>مشاركة</th>
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
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
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
    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js"
                type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js"
                type="text/javascript"></script>
     {{--   <script src="{{url('')}}/assets/pages/scripts/ui-blockui.js" type="text/javascript"></script>--}}

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
            /*var UIBlockUI = function() {
                var handleSample4 = function() {

                    /!*$('#blockui_sample_4_1').click(function() {
                        App.blockUI({
                            target: '#files_tbl',
                            boxed: true,
                            message: 'Processing...'
                        });

                        window.setTimeout(function() {
                            App.unblockUI('#files_tbl');
                        }, 2000);
                    });*!/


                }
                return {
                    //main function to initiate the module
                    init: function() {

                        handleSample4();

                    }

                };
            }();*/
            $(document).ready(function () {
              //  UIBlockUI.init();
                $('#files_tbl').dataTable({

                    'processing': true,
                    'serverSide': true,
                    'ajax': '{{url('/file/file-data')}}',
                    'columns': [
                        {data: 'num', name: 'num'},
                        {data: 'fileLinks', name: 'fileLinks'},
                        {data: 'type_desc', name: 'type_desc'},
                        {data: 'file_loc', name: 'file_loc'},
                        {data: 'file_note', name: 'file_note'},
                        {data: 'file_share_desc', name: 'file_share_desc'},
                        {data: 'action', name: 'action'},

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
            })
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
                var hdn_file_no = $('#hdn_file_no').val();
                var formData = new FormData($('#upload_form')[0]);
                formData.append('hdn_file_no', hdn_file_no),
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
                                  //  alert('success')
                                    App.unblockUI('#upload_form');
                                    $('#tb_files').html(data.table);
                                    $('#file_type').val('');
                                    $('#file_location').val('');
                                    $('.select2').trigger('change');
                                    $('#file_note').html('');
                                    $('#file_note').val('');
                                    $('#file_title').val('');
                                    $('#file_name').val('');
                                    $('.fileinput-filename').html('');
                                    $("#file_share").prop("checked", false);
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
                        url: '{{url('file/deleteFile')}}',

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
