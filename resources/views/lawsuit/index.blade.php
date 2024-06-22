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
                    <i class="fa fa-gift"></i>&nbsp;{{$page_title}}
                </div>
                <div class="tools">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <a href="#" onclick="saveSession('procedure/create/')" class="btn btn-sm red">إجراء</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" onclick="saveSession('order/create/')" class="btn btn-sm blue">طلب</a>
                        </div>
                        <div class="col-md-3">
                            <a href="#" onclick="saveSession('session/create/')"
                               class="btn btn-sm yellow-lemon">جلسة</a>
                        </div>
                        <div class="col-md-3">
                            {{Form::open(['url'=>url('lawsuit/print'),'class'=>'form-horizontal','method'=>"post","id"=>"report_form"])}}
                            <button type="submit" class="btn default"><i class="fa fa-print font-black"></i></button>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                {{--  <form action="{{url('admin/user/'.$user_id)}}" class="form-horizontal" method="post">--}}
                {{Form::open(['url'=>'','class'=>'form-horizontal','method'=>"post",'id'=>'lawsuit_form'])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input type="hidden" id="hdn_file_no" name="hdn_file_no" value="{{$one_lawsuit->id}}"/>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">رقم الملف</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="file_no" type="text"
                                               class="form-control input-left "
                                               placeholder="" value="{{$one_lawsuit->file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-file"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في الشرطة</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="police_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->police_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">المحكمة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6 ">
                                    <div class="input-group">
                                        <select id="court_id" name="court_id" class="form-control select2 " disabled>

                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($courts as $court) {
                                                $selected = '';
                                                if ($one_lawsuit->court_id == $court->id)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $court->id . '"' . $selected . ' >' . $court->desc . '</option>';

                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في المحكمة</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="court_file_no" type="text"
                                               class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->court_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">نوع الدعوة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select id="lawsuit_type" name="lawsuit_type" class="form-control select2"
                                                disabled>
                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($lawsuitTypes as $lawsuitType) {
                                                $selected = '';
                                                if ($one_lawsuit->lawsuit_type == $lawsuitType->id)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $lawsuitType->id . '"' . $selected . '>' . $lawsuitType->desc . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في الإستئناف</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="appeal_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->appeal_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">قيمة الدعوة</label>
                                <div class="col-md-6">
                                    <div class="input-icon input-group col-md-12">
                                        <i class="fa fa-money"></i>
                                        <input name="lawsuit_value" type="number" class="form-control input"
                                               placeholder="القيمة المالية" value="{{$one_lawsuit->lawsuit_value}}"
                                               min="0" disabled></div>
                                </div>
                            </div>
                            {{-- <div class="form-group">
                                 <label class="col-md-3 control-label">نوع الدعوى <span
                                         class="required"> * </span></label>
                                 <div class="col-md-6">
                                     <div class="input-icon input-group col-md-12">
                                         <i class="fa fa-balance-scale"></i>
                                         <input name="suit_type" type="text" class="form-control input"
                                                placeholder="نوع الدعوى" value="{{$one_lawsuit->suit_type}}"></div>
                                 </div>
                             </div>--}}
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في النقض</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="veto_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->veto_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">جهة الدعوة</label>
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <i class="icon-user"></i>
                                        <input name="judge" type="text" class="form-control input"
                                               placeholder="جهة الدعوى" value="{{$one_lawsuit->judge}}" disabled></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى التنفيذية</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="executive_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->executive_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="multiple" class="control-label col-md-3">المحامي
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select id="lawyers" name="lawyers[]" class="form-control select2-multiple"
                                                multiple disabled>

                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($lawyers as $lawyer) {
                                                $selected = '';

                                                foreach ($lawsuit_lawyers as $resplawyer) {

                                                    if ($resplawyer->lawyer_id == $lawyer->emp_id)
                                                        $selected = 'selected="selected"';


                                                }
                                                echo '<option value="' . $lawyer->emp_id . '"' . $selected . '>' . $lawyer->name . '</option>';
                                            }


                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في النيابة العامة</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="prosecution_file_no" type="text"
                                               class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->prosecution_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">حركة الملف
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select id="file_location" name="file_location" class="form-control select2"
                                                disabled>
                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($FileLocations as $FileLocation) {
                                                $selected = '';
                                                if ($one_lawsuit->file_location == $FileLocation->id)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $FileLocation->id . '"' . $selected . ' >' . $FileLocation->desc . '</option>';

                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الإخطار</label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <input name="noti_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="{{$one_lawsuit->noti_file_no}}" disabled>
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-cog"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            @if (auth()->user()->user_role==5)
                                <div class="form-group">
                                    <label for="multiple" class="control-label col-md-3">مصدر الدعوة</label>
                                    <div class="col-md-6">
                                        <select id="lawsources" name="lawsources[]"
                                                class="form-control select2-multiple"
                                                multiple disabled>

                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($externalEmps as $externalEmp) {
                                                $selected = '';

                                                foreach ($lawsuit_sources as $lawsuit_source) {

                                                    if ($lawsuit_source->lawyer_id == $externalEmp->id)
                                                        $selected = 'selected="selected"';


                                                }
                                                echo '<option value="' . $externalEmp->id . '"' . $selected . '>' . $externalEmp->name . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>

                                </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">حالة الدعوة
                                    <span class="required"> * </span></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <select id="file_status" name="file_status" class="form-control select2"
                                                onchange="check_file_result()" disabled>
                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($FileStatuses as $FileStatuse) {
                                                $selected = '';
                                                if ($one_lawsuit->file_status == $FileStatuse->id)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $FileStatuse->id . '"' . $selected . ' >' . $FileStatuse->desc . '</option>';

                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">

                        </div>
                        <?php
                        $css = 'style="display:none;"';
                        if ($one_lawsuit->file_status == 3)
                            $css = 'style="display:block;"';
                        ?>
                        <div class="col-md-6" <?php echo $css ?> id="resutDv">
                            <div class="form-group">
                                <label class="col-md-6 control-label"> نتيجة الدعوة
                                    <span class="required"> * </span></label>
                                <div class="col-md-5">
                                    <div class="input-group">
                                        <select id="lawsuit_result" name="lawsuit_result" class="form-control select2"
                                                disabled>
                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($lawsuitResults as $lawsuitResult) {
                                                $selected = '';
                                                if ($one_lawsuit->lawsuit_result == $lawsuitResult->id)
                                                    $selected = 'selected="selected"';
                                                echo '<option value="' . $lawsuitResult->id . '"' . $selected . ' >' . $lawsuitResult->desc . '</option>';

                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="form-actions left">
                    <div class="row ">
                        <div class="col-md-9">

                            <a href="{{url('/home')}}" class="btn btn grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-red-haze"></i>
                            <span class="caption-subject font-red-haze bold uppercase">الموكلين</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body form">


                        <div class="table-scrollable" id="tableDv">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    {{--  <th> #</th>--}}
                                    <th> رقم الهوية</th>
                                    <th> الاسم</th>
                                    <th> جوال</th>
                                    <th> العنوان</th>
                                    <th> البريد الإلكتروني</th>
                                    <th>رقم هوية الوكيل</th>
                                    <th> اسم الوكيل</th>

                                </tr>
                                </thead>
                                <tbody id="tb_agent">
                                <?php echo $agents; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>

            </div>
        </div>
        <div class="row ">
            <div class="col-md-12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet light ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-share font-red-haze"></i>
                            <span class="caption-subject font-red-haze bold uppercase">الخصوم</span>
                        </div>
                        <div class="actions">

                        </div>
                    </div>
                    <div class="portlet-body form">


                        <div class="table-scrollable" id="resp_tableDv">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    {{--  <th> #</th>--}}
                                    <th> رقم الهوية</th>
                                    <th> الاسم</th>
                                    <th> جوال</th>
                                    <th> عنوان</th>


                                </tr>
                                </thead>
                                <tbody id="tb_respondents">
                                <?php echo $respondents; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title"> المستندات </h3>
                    </div>

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
                                <?php echo $files; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
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
            function saveSession(url) {
                //   alert(url);
                var id = $('#hdn_file_no').val();
                if (id != '' && id != null) {


                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: '{{url('set-id')}}',

                        data: {id: id, url: url},
                        error: function (xhr, status, error) {

                        },
                        beforeSend: function () {
                        },
                        complete: function () {
                        },
                        success: function (data) {

                            window.location.href = '{{url('/')}}/' + url;
                        }
                    });//END $.ajax
                }
            }
        </script>
    @endpush
@stop
