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
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
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
                    <input type="hidden" id="hdn_master_id" value="{{''}}">
                    <div class="form-group">
                        <label class="col-md-3 control-label"> الموظف</label>
                        <div class="col-md-5">
                            <select class="form-control select2" id="emp_id" onchange="getSystemRate();">

                                <option value="0">اختر موظف..</option>


                                @foreach ($emp as $e)


                                    <option value="{{$e->emp_id}}">{{$e->name}}</option>
                                @endforeach


                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="multiple" class="control-label col-md-3">نظام التقييم</label>
                        <div class="col-md-5">
                            <select id="eval_id" name="eval_id" class="form-control select2"
                                    onchange="getSystemRate();">
                                <option value="0">اختر ..</option>

                                <?php

                                foreach ($evalSystems as $evalSystem) {

                                    echo '<option value="' . $evalSystem->id . '">' . $evalSystem->desc . '</option>';
                                }

                                ?>


                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-actions left">
                    <div class="row">
                        <div class=" col-md-9">

                            <a href="{{url('/rating')}}" class="btn  grey-salsa btn-outline">عودة</a>

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
                    <i class="fa fa-gift"></i>معاير التقييم
                </div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>

                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-body">
                    <table class="table table-striped table-bordered table-hover table-checkable order-column"
                           id="rating_tbl">
                        <thead>
                        <tr>
                            <th> #</th>
                            <th> المعيار</th>
                            <th> الدرجة</th>
                            <th>التقييم</th>

                        </tr>
                        </thead>
                        <tbody id="tb_rate">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    @push('css')
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
        <link href="{{url('')}}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet"
              type="text/css"/>


    @endpush
    @push('js')
        <script src="{{url('')}}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script src="{{url('')}}/assets/pages/scripts/components-select2.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                /* var table =  $('#rating_tbl').dataTable({

                     'processing': true,
                     'serverSide': true,
                     'ajax': '{{url('rate/getSystemRate')}}',
                    'columns': [

                        {data: 'num', name: 'num'},
                        {data: 'rates_desc', name: 'Rates_desc'},
                        {data: 'Rates.value', name: 'Rates.value'},
                        {data:'eval_rate_id',name:'eval_rate_id'},


                    ]

                })*/


            })

            function saveEmpRate(element) {
                var eval_id = $('#eval_id').val();
                var rate_value = $(element).val();
                var rate_id = $(element).attr('data-id');
                var hdn_id = $(element).attr('data-hdn-id');
                var orginal_rate_value = $(element).attr('data-value');
                var master_id = $('#hdn_master_id').val();
                var emp_id = $('#emp_id').val();

                if (parseInt(rate_value) > parseInt(orginal_rate_value)) {
                    alert('القيمة المدخلة تجاوزت حد التقييم')
                    return false
                }
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (rate_value != '')
                    $.ajax({
                            type: "POST",
                            url: '{{url('rate/saveEmpRate')}}',
                            data: {
                                eval_id: eval_id,
                                rate_id: rate_id,
                                rate_value: rate_value,
                                emp_id: emp_id,
                                hdn_id: hdn_id,
                                master_id: master_id
                            },

                            success:

                                function (data) {
                                    if (data.success) {


                                        $(element).attr('data-hdn-id', data.detail_id);
                                        if (data.master_id != '')
                                            $('#hdn_master_id').val(data.master_id);
                                    }
                                }

                            ,
                            error: function (err) {

                                console.log(err);
                            }

                        }
                    )
            }

            function getSystemRate() {
                var id = $('#eval_id').val();
                var emp_id = $('#emp_id').val();
                //  alert(id);
                $('#tb_rate').html('');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                        type: "POST",
                        url: '{{url('rate/getSystemRate')}}',
                        data: {id: id, emp_id: emp_id},

                        success:

                            function (data) {
                                if (data.success) {

                                    $('#tb_rate').html(data.table);
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
