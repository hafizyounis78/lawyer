<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- END SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-hover-submenu " data-keep-expanded="false"
            data-auto-scroll="true" data-slide-speed="200">
            <li class="nav-item start {{@$sub_menu == "home" ?'open active' : ''}} ">
                <a href="{{url('/home')}}" class="nav-link nav-toggle">
                    <i class="icon-home "></i>
                    <span class="title">الرئيسية</span>
                    <span class="arrow"></span>
                </a>

            </li>
            @foreach(auth()->user()->user_menu as $menu)
                <li class="nav-item {{@$sub_menu == "lawsuit" ?'open active' : ''}} ">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="{{$menu->menu_icon}}"></i>
                        <span class="title">{{$menu->menu_display_name}}</span>
                        <span class="arrow"></span>
                    </a>

                    <ul class="sub-menu">
                        @foreach($menu->sub_menu as $sub_menu)
                        <li class="nav-item  ">
                            <a href="{{url($sub_menu->screen_link)}}" class="nav-link ">
                                <span class="title">{{$sub_menu->display_name}}</span>
                            </a>
                        </li>
                            @endforeach
                    </ul>
                </li>
            @endforeach
            {{--<li class="nav-item  ">
                <a href="{{url('lawsuit/create')}}" class="nav-link ">
                    <span class="title">فتح ملف جديد</span>
                </a>
            </li>

        </ul>
        </li>
        <li class="nav-item {{@$sub_menu == "task" ?'open active' : ''}} ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-briefcase"></i>
                <span class="title">المهام</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="{{url('/task')}}" class="nav-link ">
                        <span class="title">عرض المهام</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/task/create')}}" class="nav-link ">
                        <span class="title">اضافة مهمة</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item {{@$sub_menu == "employee" ?'open active' : ''}} ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-diamond"></i>
                <span class="title">الموظفين</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="{{url('/employee')}}" class="nav-link ">
                        <span class="title">عرض الموظفين</span>
                    </a>
                </li>

                <li class="nav-item  ">
                    <a href="{{url('/employee/create')}}" class="nav-link ">
                        <span class="title">اضافة موظف</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/attendance')}}" class="nav-link ">
                        <span class="title">الحضور والانصراف</span>
                    </a>
                </li>

            </ul>
        </li>

        <li class="nav-item {{@$sub_menu == "rating" ?'open active' : ''}} ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-wallet"></i>
                <span class="title">ادارة التقييم</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">

                <li class="nav-item  ">
                    <a href="{{url('/setting/s6')}}" class="nav-link ">
                        <span class="title">معاير التقيم</span>
                    </a>
                </li>
                --}}{{-- <li class="nav-item  ">
                     <a href="{{url('/setting/s7')}}" class="nav-link ">
                         <span class="title">انظمة التقيم</span>
                     </a>
                 </li>--}}{{--
                <li class="nav-item  ">
                    <a href="{{url('/setting/s8')}}" class="nav-link ">
                        <span class="title">ادارة التقييمات</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/rating')}}" class="nav-link ">
                        <span class="title">تقييم الموظفين</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item {{@$sub_menu == "role" ?'open active' : ''}} ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-bar-chart"></i>
                <span class="title">ادارة الصلاحيات</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="nav-item  ">
                    <a href="{{url('/user')}}" class="nav-link ">
                        <span class="title">المستخدمين</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/role')}}" class="nav-link ">
                        <span class="title">فئات المستخدمين</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/permission')}}" class="nav-link ">
                        <span class="title">انواع الصلاحيات</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/role_permission')}}" class="nav-link ">
                        <span class="title"> صلاحيات فئات المستخدمين</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/user_permission')}}" class="nav-link ">
                        <span class="title">منح الصلاحيات للمستخدمين</span>
                    </a>
                </li>

            </ul>
        </li>
        <li class="nav-item {{@$sub_menu == "setting" ?'open active' : ''}} ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-cogs"></i>
                <span class="title">اعدادت النظام</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">

                <li class="nav-item  ">
                    <a href="{{url('/setting/s1')}}" class="nav-link ">
                        <span class="title"> انواع الملف القضائي</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/setting/s11')}}" class="nav-link ">
                        <span class="title"> حالات الملف القضائي</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/setting/s2')}}" class="nav-link ">
                        <span class="title"> انواع الملفات </span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/setting/s3')}}" class="nav-link ">
                        <span class="title"> المحافظات</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/setting/s4')}}" class="nav-link ">
                        <span class="title"> المحاكم</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="{{url('/setting/s5')}}" class="nav-link ">
                        <span class="title"> الوظائف</span>
                    </a>
                </li>


            </ul>
        </li>
        <li class="nav-item last ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="fa fa-cogs"></i>
                <span class="title">التقارير</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">

                <li class="nav-item  ">
                    <a href="#" class="nav-link ">
                        <span class="title"> تقرير الملفات القضائية</span>
                    </a>
                </li>


            </ul>
        </li>--}}
        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
@push('css')
    <style>

        .page-header.navbar .page-logo {
            background: #dedede !important ;
        }
    </style>

@endpush
