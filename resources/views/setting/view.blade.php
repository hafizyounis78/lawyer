@extends('admin.layout.index')
@section('content')
    <div class="page-content">
        <h1 class="page-title"> {{$title}}
          {{--  <small>{{$page_title}}</small>--}}
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
                            <span class="caption-subject bold uppercase">{{$title}}</span>
                        </div>

                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <div class="row">

                                <a href="{{url('/setting/s1')}}" class="btn  btn-lg red-sunglo">انواع الملف القضائي</a>
                                <a href="{{url('/setting/s9')}}" class="btn  btn-lg red">حالات الملف القضائي</a>
                                <a href="{{url('/setting/s2')}}" class="btn  btn-lg  green-meadow">نوع الملف </a>
                                <a href="{{url('/setting/s3')}}" class="btn  btn-lg  grey-cascade">المحافظات</a>
                                <a href="{{url('/setting/s5')}}"  class="btn  btn-lg  yellow-crusta">الوظائف</a>
                                <a href="{{url('/setting/s4')}}" class="btn  btn-lg  blue-madison">المحاكم</a>

                                <a href="{{url('/setting/s6')}}" class="btn  btn-lg  purple-sharp">معاير التقييم</a>
                               {{-- <a href="{{url('/setting/s7')}}" class="btn  btn-lg  dark">انظمة التقييم</a>--}}
                                <a href="{{url('/setting/s8')}}" class="btn  btn-lg dark">ادارة التقييم</a>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
    </div>

@stop