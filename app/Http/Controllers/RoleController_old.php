<?php

namespace App\Http\Controllers;

use App\Permission;
use App\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function role()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض فئات المستخدمين';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'اضافة فئة جديد';

        //dd($user);
        return view(role_vw() . '.role')->with($this->data);
    }

    public function roleData()
    {
        $table = Role::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div>
                <div class="col-md-2">
                <form action="" method="POST">
' . method_field('DELETE') . '

<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض انواع الصلاحيات';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'اضافة نوع جديد';

        //dd($user);
        return view(role_vw() . '.permission')->with($this->data);
    }

    public function permissionData()
    {
        $table = Permission::with('menu');
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('menu_desc', function ($table) {// as foreach ($users as $user)

                return $table->menu->menu_display_name;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="" type="button" class=" btn btn-icon-only green"><i class="fa fa-edit"></i></a> 
                </div>
                <div class="col-md-2">
                <form action="" method="POST">
' . method_field('DELETE') . '

<input type="hidden" name="_token" value="' . csrf_token() . '">
<button  type="submit" class="btn btn-icon-only red"><i class="fa fa-times"></i></button>
</form></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function role_permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض صلاحيات الفئات';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'صلاحيات الفئات';

        //dd($user);
        return view(role_vw() . '.role_permission')->with($this->data);
    }
    public function user_permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض صلاحيات المستخدمين';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'صلاحيات المستخدمين';

        //dd($user);
        return view(role_vw() . '.user_permission')->with($this->data);
    }

}
