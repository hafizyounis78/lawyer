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
        @if($errors->any())
            <div class="alert alert-danger">
                <button class="close" data-close="alert"></button>
                <h4>{{$errors->first()}}</h4>
            </div>
        @endif
        <div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                    <i class="fa fa-gift"></i>&nbsp;{{$page_title}}&nbsp;
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
                {{Form::open(['url'=>url('lawsuit'),'class'=>'form-horizontal','method'=>"post","id"=>"lawsuit_form"])}}

                <div class="form-body">
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        يوجد خطأ في ادخال البيانات,يرجى فحص القيم المدخلة
                    </div>
                    <div class="alert alert-success display-hide">
                        <button class="close" data-close="alert"></button>
                        تمت عملية الحفظ بنجاح!
                    </div>
                    <input type="hidden" id="hdn_file_no" name="hdn_file_no" value="{{''}}"/>
                    <input type="hidden" name="file_counter" value="{{$file_counter}}"/>
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">المحكمة
                                    <span class="required"> * </span></label>
                                <div class="col-md-6 ">
                                    <div class="input-group">
                                        <select id="court_id" name="court_id" class="form-control select2 ">

                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($courts as $court) {

                                                echo '<option value="' . $court->id . '">' . $court->desc . '</option>';
                                            }

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في الشرطة</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="police_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                <label class="col-md-3 control-label">رقم الملف</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="file_no" type="text"
                                               class="form-control input-left "
                                               placeholder="" value="">
                                        <span class="input-group-addon input-right">
                                                                            <i class="fa fa-file"></i>
                                                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في المحكمة</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="court_file_no" type="text"
                                               class="form-control input-left"
                                               placeholder="" value="">
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
                                <label class="col-md-3 control-label">نوع الدعوى
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select id="lawsuit_type" name="lawsuit_type" class="form-control select2">
                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($lawsuitTypes as $lawsuitType) {

                                                echo '<option value="' . $lawsuitType->id . '">' . $lawsuitType->desc . '</option>';
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
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="appeal_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                <label class="col-md-3 control-label"> تفصيل الدعوى</label>
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <i class="icon-user"></i>
                                        <input name="suit_type" type="text" class="form-control input"
                                               placeholder="تفصيل الدعوى" value=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى في النقض</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="veto_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                <label class="col-md-3 control-label">قيمة الدعوى</label>
                                <div class="col-md-3">
                                    <div class="input-icon input-group col-md-12">
                                        <i class="fa fa-money"></i>
                                        <input name="lawsuit_value" type="text" class="form-control input"
                                               placeholder="القيمة المالية" value="0" min="0"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select id="currency" name="currency" class="form-control select2">
                                            <option value="0">اختر قيمة..</option>
                                            <option value="1">شيكل NIS</option>
                                            <option value="2">دولار US</option>
                                            <option value="3">دينار JOD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">قيمة الدعوى(2) </label>
                                <div class="col-md-3">
                                    <div class="input-icon input-group col-md-12">
                                        <i class="fa fa-money"></i>
                                        <input name="lawsuit_value2" type="text" class="form-control input"
                                               placeholder="القيمة المالية" value="0" min="0"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <select id="currency2" name="currency2" class="form-control select2">
                                            <option value="0">اختر قيمة..</option>
                                            <option value="1">شيكل NIS</option>
                                            <option value="2">دولار US</option>
                                            <option value="3">دينار JOD</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">جهة الدعوى</label>
                                <div class="col-md-6">
                                    <div class="input-icon">
                                        <i class="icon-user"></i>
                                        <input name="judge" type="text" class="form-control input"
                                               placeholder="جهة الدعوى" value=""></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الدعوى التنفيذية</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="executive_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                                multiple>

                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($lawyers as $lawyer) {

                                                echo '<option value="' . $lawyer->emp_id . '">' . $lawyer->name . '</option>';
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
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="prosecution_file_no" type="text"
                                               class="form-control input-left"
                                               placeholder="" value="">
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
                                        <select id="file_location" name="file_location" class="form-control select2">
                                            <option value="">اختر قيمة</option>


                                            <?php
                                            $selected = '';
                                            foreach ($FileLocations as $FileLocation)

                                                echo '<option value="' . $FileLocation->id . '"' . $selected . ' >' . $FileLocation->desc . '</option>';

                                            ?>


                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الشكوى</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="complaint_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                    <label for="multiple" class="control-label col-md-3">مصدر الدعوى</label>
                                    <div class="col-md-6">
                                        <select id="lawsources" name="lawsources[]"
                                                class="form-control select2-multiple"
                                                multiple>

                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($externalEmps as $externalEmp) {

                                                echo '<option value="' . $externalEmp->id . '">' . $externalEmp->name . '</option>';
                                            }

                                            ?>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">رقم الإخطار</label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input name="noti_file_no" type="text" class="form-control input-left"
                                               placeholder="" value="">
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
                                <label class="col-md-3 control-label">ملاحظات</label>
                                <div class="col-md-6">
                                    <textarea class="form-control" name="lawsuit_note" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-6 control-label">حالة الدعوى
                                    <span class="required"> * </span></label>
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select id="file_status" name="file_status" class="form-control select2">
                                            <option value="">اختر قيمة</option>


                                            <?php

                                            foreach ($FileStatuses as $FileStatuse) {

                                                echo '<option value="' . $FileStatuse->id . '">' . $FileStatuse->desc . '</option>';
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
                            <button type="submit" class="btn btn green">حفظ</button>
                            <a href="{{url('/lawsuit')}}" class="btn btn grey-salsa btn-outline">عودة</a>
                        </div>
                    </div>
                </div>
            {{-- </form>--}}
            {{Form::close()}}
            <!-- END FORM-->
            </div>
        </div>
        <div class="row " id="agentDiv" style="display: none">
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

                        {{--  <h4>اضافة الموكلين</h4>--}}
                        {{Form::open(['url'=>url('addAgent'),'class'=>'form-inline','role'=>'form','method'=>"post","id"=>"agent_form"])}}
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
                        <input type="hidden" id="hdn_id" name="hdn_id" value="{{''}}">
                        <div class="row">
                            <div class="form-group ">
                                <label class="sr-only" for="national_id">رقم الهوية</label>
                                <div class="input-icon input-group ">
                                    <i class="fa fa-cog"></i>
                                    <input name="national_id" id="national_id" type="text"
                                           class="form-control input-sm col-sm-3"
                                           placeholder="رقم الهوية" onchange="get_agent_by_id();"></div>
                            </div>
                            <div class="form-group ">
                                <label class="sr-only" for="name">الاسم</label>
                                <div class="input-icon input-group " id="remote">
                                    <i class="fa fa-user"></i>
                                    <input name="name" id="name" type="text"
                                           class="form-control typeahead select2_sample2 input-sm"
                                           placeholder="الاسم">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="sr-only" for="mobile">جوال</label>
                                <div class="input-icon input-group">
                                    <i class="fa fa-mobile-phone"></i>
                                    <input name="mobile" id="mobile" type="text" class="form-control input-sm col-sm-3"
                                           placeholder="جوال"></div>
                            </div>
                            <div class="form-group ">
                                <label class="sr-only" for="address">العنوان</label>
                                <div class="input-icon input-group  ">
                                    <i class="icon-home"></i>
                                    <input name="address" id="address" type="text"
                                           class="form-control input-sm col-sm-3"
                                           placeholder="العنوان"></div>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="email">البريد الإلكتروني</label>
                                <div class="input-icon input-group ">
                                    <i class="fa fa-enveloper"></i>
                                    <input name="email" id="email" type="email" class="form-control input-sm col-sm-3"
                                           placeholder="البريد الإلكتروني"></div>
                            </div>
                            <div class="form-group">

                                <div class="mt-checkbox-inline">
                                    <label class="mt-checkbox">
                                        <input type="checkbox" id="isWakel" value="" class="input-sm col-sm-3"> وكيل؟
                                        <span></span>
                                    </label>

                                </div>
                            </div>
                        </div>

                        <div class="row" style="display: none" id="wakelDv">

                            <label class="form-section bold">وكيل العدل</label>
                            <br>
                            <div class="form-group">

                                <div class="input-icon input-group ">
                                    <i class="fa fa-cog"></i>
                                    <input name="justice_national_id" id="justice_national_id" type="text"
                                           class="form-control input-sm col-sm-3"
                                           placeholder="رقم الهوية"></div>
                            </div>
                            <div class="form-group">

                                <div class="input-icon input-group ">
                                    <i class="fa fa-user"></i>
                                    <input name="justice_name" id="justice_name" type="text"
                                           class="form-control input-sm col-sm-3"
                                           placeholder="الاسم">
                                </div>
                            </div>
                            {{--</div>--}}


                        </div>
                        <br>
                        <button type="submit" class="btn blue " id="agent_btn">اضافة</button>
                        {{--</div>--}}
                        {{Form::close()}}
                        {{--  </form>--}}

                        <hr>
                        <div class="table-scrollable" style="display: none" id="tableDv">
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
                                    <th>تحكم</th>
                                </tr>
                                </thead>
                                <tbody id="tb_agent">

                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>

            </div>
        </div>
        <div class="row " id="respondentsDiv" style="display: none">
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

                        {{--  <h4>اضافة الموكلين</h4>--}}
                        {{Form::open(['url'=>url('addRespondent'),'class'=>'form-inline','role'=>'form','method'=>"post","id"=>"respondent_form"])}}
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
                        <input type="hidden" id="resp_hdn_id" name="resp_hdn_id" value="{{''}}">
                        {{--<div class="row">--}}
                        <div class="form-group ">
                            <label class="sr-only" for="national_id">رقم الهوية</label>
                            <div class="input-icon input-group ">
                                <i class="fa fa-cog"></i>
                                <input name="resp_national_id" id="resp_national_id" type="text" class="form-control"
                                       placeholder="رقم الهوية"></div>
                        </div>
                        <div class="form-group ">
                            <label class="sr-only" for="name">الاسم</label>
                            <div class="input-icon input-group ">
                                <i class="fa fa-user"></i>
                                <input name="resp_name" id="resp_name" type="text" class="form-control"
                                       placeholder="الاسم">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="sr-only" for="mobile">جوال</label>
                            <div class="input-icon input-group">
                                <i class="fa fa-mobile-phone"></i>
                                <input name="resp_mobile" id="resp_mobile" type="text" class="form-control"
                                       placeholder="جوال"></div>
                        </div>
                        <div class="form-group ">
                            <label class="sr-only" for="address">العنوان</label>
                            <div class="input-icon input-group  ">
                                <i class="icon-home"></i>
                                <input name="resp_address" id="resp_address" type="text" class="form-control"
                                       placeholder="العنوان"></div>
                        </div>

                        <button type="submit" class="btn blue ">اضافة</button>
                        {{--</div>--}}
                        {{Form::close()}}
                        {{--  </form>--}}

                        <hr>
                        <div class="table-scrollable" style="display: none" id="resp_tableDv">
                            <table class="table table-hover table-striped">
                                <thead>
                                <tr>
                                    {{--  <th> #</th>--}}
                                    <th> رقم الهوية</th>
                                    <th> الاسم</th>
                                    <th> جوال</th>
                                    <th> عنوان</th>
                                    <th>تحكم</th>

                                </tr>
                                </thead>
                                <tbody id="tb_respondents">

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
                        <h3 class="panel-title">تحميل المستندات </h3>
                    </div>
                    {{Form::open(['url'=>url('lawsuit/uploadFile'),'class'=>'form-horizontal','method'=>"post",'files' => true,"id"=>"upload_form",""])}}

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
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet"
              type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>
        <!-- BEGIN PAGE LEVEL PLUGINS -->
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
        <link href="{{url('')}}/assets/global/plugins/typeahead/typeahead.css" rel="stylesheet" type="text/css"/>
        <!-- END PAGE LEVEL PLUGINS -->
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
        <script src="{{url('')}}/assets/global/plugins/typeahead/handlebars.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/global/plugins/typeahead/typeahead.bundle.min.js"
                type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        {{--<script src="{{url('')}}/assets/pages/scripts/components-typeahead.js" type="text/javascript"></script>--}}
        <script>
            var ComponentsTypeahead = function () {

                var handleTwitterTypeahead = function () {


                    var custom = new Bloodhound({

                        datumTokenizer: function (d) {
                            return d.tokens;
                        },
                        queryTokenizer: Bloodhound.tokenizers.whitespace,

                        remote: {
                            url: '{{url('agent/get-agents-name?query=%QUERY')}}',
                            wildcard: '%QUERY'
                        }
                    });

                    custom.initialize();

                    if (App.isRTL()) {
                        $('#name').attr("dir", "rtl");
                    }
                    $('#name').typeahead(null, {
                        name: 'name',
                        displayKey: 'name',
                        source: custom.ttAdapter(),
                        hint: (App.isRTL() ? false : true),
                        templates: {
                            suggestion: Handlebars.compile([
                                '<h4 class="media-heading">@{{name}}</h4>',
                            ].join(''))
                        }
                    });
                    $('#name').on('typeahead:select', function (evt, item) {
                        // alert(item.name);


                        if (item.national_id != '')
                            $('#national_id').val(item.national_id);
                        if (item.mobile != '')
                            $('#mobile').val(item.mobile);
                        if (item.address != '')
                            $('#address').val(item.address);
                        if (item.email != '')
                            $('#email').val(item.email);


                        // Your Code Here
                    })
//*********

                    //******************
                }
                return {
                    //main function to initiate the module
                    init: function () {
                        handleTwitterTypeahead();

                    }
                };

            }();
            jQuery(document).ready(function () {
                ComponentsTypeahead.init();
            });

            var lawsuitFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#lawsuit_form');
                    var error1 = $('.alert-danger', form1);
                    var success1 = $('.alert-success', form1);
                    // Unique File No
                    var response = true;
                    $.validator.addMethod(
                        "uniqLawsuitFile",
                        function (value, element) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                type: "POST",
                                url: '{{url('lawsuit/check-File-No')}}',

                                data: {file_no: value, court_id: $('#court_id').val()},
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
                        "رقم الملف المدخل موجود مسبقا,يرجى التأكد من القيمة المدخلة"
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
                            file_no: {
                                required: true,
                                uniqLawsuitFile: true

                            },
                            court_id: {
                                required: true,

                            },
                            lawsuit_type: {
                                required: true,


                            },
                            /* suit_type: {
                                 required: true,

                             },*/
                            lawyers: {
                                required: true,
                                minlength: 1
                            },
                            lawsuit_value:
                                {
                                    minlength: 0,
                                    number: true
                                }

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            file_no: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",
                                uniqLawsuitFile: "رقم الملف المدخل موجود مسبقاً"

                            },
                            court_id: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",

                            },

                            lawsuit_type: {
                                required: "هذه الحقل مطلوب,الرجاء اختيار قيمة",
                            },
                            /*suit_type: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                            },*/
                            lawyers: {
                                required: "يرجى اختيار قيمة واحدة على الاقل",
                                minlength: jQuery.validator.format("At least {0} items must be selected")
                            },
                            lawsuit_value:
                                {
                                    minlength: "القيمة المدخلة جيب ان تكون اكبر من 0 ",
                                    number: "أرقام فقط"
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

                            lawsuitSubmit();

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
            lawsuitFormValidation.init();

            function lawsuitSubmit() {

                var form1 = $('#lawsuit_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#lawsuit_form').attr('action');
                //var file_no = $('#file_no').html();

                var formData = new FormData($('#lawsuit_form')[0]);
                //formData.append('file_no', file_no),
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

                                    $('#hdn_file_no').val(data.file_id);

                                    $('#agentDiv').css('display', 'block');
                                    var showdiv = $('#agentDiv')
                                    App.scrollTo(showdiv, -200);
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
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }

            //********************************************************************
            var agentFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#agent_form');
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

                            national_id: {
                                digits: true,
                                maxlength: 9

                            },
                            justice_national_id: {
                                digits: true,
                                maxlength: 9

                            },
                            name: {
                                minlength: 2,
                                required: true
                            },
                            email: {

                                email: true,

                            },
                            mobile: {
                                required: true,
                                digits: true,
                                maxlength: 10

                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            name: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                minlength: "القيمة المدخلة غير مناسبة ,الرجاء ادخال قيمة أكبر من حرفني"
                            },
                            national_id: {
                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: "ادخل رقم اقل من 9 خانة"
                            },
                            justice_national_id: {
                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: "ادخل رقم اقل من 9 خانة"
                            },

                            email: {

                                email: "الرجاء التأكد من القيمة المدخلة, مثال user@admin.com"
                            },
                            mobile: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: "ادخل رقم اقل من 10 خانة"


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


                            agentSubmit();


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
            agentFormValidation.init();

            function agentSubmit() {
                var form1 = $('#agent_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#agent_form').attr('action');
                var hdn_file_no = $('#hdn_file_no').val();
                var formData = new FormData($('#agent_form')[0]);
                formData.append('hdn_file_no', hdn_file_no),
                    formData.append('hdn_file_no', hdn_file_no),

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

                                    $('#hdn_id').val('');
                                    $('#national_id').val('');
                                    $('#name').val('');
                                    $('#mobile').val('');
                                    $('#email').val('');
                                    $('#address').val('');
                                    $('#justice_national_id').val('');
                                    $('#justice_name').val('');
                                    $('#tableDv').css('display', 'block');
                                    $("#tb_agent").html(data.agent);
                                    var showdiv = $('#agent_btn')
                                    App.scrollTo(showdiv, -200);
                                    $('#respondentsDiv').css('display', 'block');
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

            function updateAgent(id = null, national_id = null, name = null, mobile = null, address = null, email = null, justice_national_id = null, justice_name = null) {
                /*alert('id= '+id+' national_id= '+national_id+' name= '+name +' mobile = '+ mobile+' address= '+address
                +' email= '+ email+' justice_national_id= '+justice_national_id+' justice_name='+justice_name);
                */
                $('#hdn_id').val(id);
                $('#national_id').val(national_id);
                $('#name').val(name);
                $('#mobile').val(mobile);
                $('#email').val(email);
                $('#address').val(address);
                $('#justice_national_id').val(justice_national_id);
                $('#justice_name').val(justice_name);


            }

            function deleteAgent(id, element) {

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
                        url: '{{url('agent-delete')}}',

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
                                $('#hdn_id').val('');
                                $('#national_id').val('');
                                $('#name').val('');
                                $('#mobile').val('');
                                $('#email').val('');
                                $('#address').val('');
                                $('#justice_national_id').val('');
                                $('#justice_name').val('');
                            }


                        }
                    });//END $.ajax
                }
            }

            //********************************************************************

            var respondentFormValidation = function () {

                // basic validation
                var handleValidation1 = function () {
                    // for more info visit the official plugin documentation:
                    // http://docs.jquery.com/Plugins/Validation

                    var form1 = $('#respondent_form');
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

                            resp_national_id: {
                                digits: true,
                                maxlength: 9

                            },
                            resp_name: {
                                minlength: 2,
                                required: true
                            },
                            resp_mobile: {

                                digits: true,
                                maxlength: 10

                            },

                        },

                        messages: { // custom messages for radio buttons and checkboxes
                            resp_name: {
                                required: "هذه الحقل مطلوب,الرجاء ادخال قيمة",
                                minlength: "القيمة المدخلة غير مناسبة ,الرجاء ادخال قيمة أكبر من حرفني"
                            },
                            resp_national_id: {
                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: "ادخل رقم اقل من 9 خانة"
                            },
                            resp_mobile: {

                                digits: "الرجاء ادخال ارقام فقط",
                                maxlength: "ادخل رقم اقل من 10 خانة"


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

                            respondentSubmit();

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
            respondentFormValidation.init();

            function respondentSubmit() {

                var form1 = $('#respondent_form');
                var error = $('.alert-danger', form1);
                var success = $('.alert-success', form1);

                var action = $('#respondent_form').attr('action');
                var hdn_file_no = $('#hdn_file_no').val();
                var formData = new FormData($('#respondent_form')[0]);
                formData.append('hdn_file_no', hdn_file_no),
                    formData.append('hdn_file_no', hdn_file_no),

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
                                    //   alert(data.agent);
                                    success.show();
                                    error.hide();
                                    App.scrollTo(success, -200);
                                    success.fadeOut(2000);

                                    $('#resp_hdn_id').val('');
                                    $('#resp_national_id').val('');
                                    $('#resp_name').val('');
                                    $('#resp_mobile').val('');
                                    $('#resp_address').val('');

                                    $('#resp_tableDv').css('display', 'block');
                                    $("#tb_respondents").html(data.respondent);

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
                        /*  error:function(err){
                              console.log(err);

                          }*/
                    }
                )
                //   });
            }

            function updateResp(id = null, national_id = null, name = null, mobile = null) {

                $('#resp_hdn_id').val(id);
                $('#resp_national_id').val(national_id);
                $('#resp_name').val(name);
                $('#resp_mobile').val(mobile);


            }

            function deleteResp(id, element) {

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
                        url: '{{url('respondent-delete')}}',

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
                                $('#resp_hdn_id').val('');
                                $('#resp_national_id').val('');
                                $('#resp_name').val('');
                                $('#resp_mobile').val('');

                                // element.parent('tr').remove();
                            }

                        }
                    });//END $.ajax
                }
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
                        url: '{{url('lawsuit/file-delete')}}',

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

            //*******************autocomplete **********
            function get_agent_by_id() {
                var national_id = $('#national_id').val();
                $('#hdn_id').val('');
                $('#name').val('');
                $('#mobile').val('');
                $('#email').val('');
                $('#address').val('');
                $('#justice_national_id').val('');
                $('#justice_name').val('');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (national_id != '')
                    $.ajax({
                        type: "POST",
                        url: '{{url('agent/get-agents-id')}}',

                        data: {national_id: national_id},
                        error: function (xhr, status, error) {
                            alert(xhr.responseText);
                        },
                        beforeSend: function () {
                        },
                        complete: function () {
                        },
                        success: function (data) {
                            if (data.success) {
                                $('#name').val(data.data.name);

                                $('#mobile').val(data.data.mobile);

                                $('#address').val(data.data.address);

                                $('#email').val(data.data.email);
                            }

                        }
                    });//END $.ajax
            }

        </script>
    @endpush
@stop
