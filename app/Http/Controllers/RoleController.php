<?php

namespace App\Http\Controllers;

use App\Menu;
use App\Permission;
use App\PermissionRole;
use App\Role;
use App\User;
use App\UserPermission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /***********************************************
     **          Role
     **
     **********************************************/
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

    public function roleStore(Request $request)
    {
        if ($request->hdn_role_id == '') {
            $role = New Role();

            $role->name = $request->get('role_name');
            $role->display_name = $request->get('role_name');
            //$role->org_id = auth()->user()->org_id;

            if ($role->save()) {
                return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

            } else
                return response()->json(['success' => false]);
        } else {
            $role = Role::find($request->hdn_role_id);
            $role->name = $request->get('role_name');
            $role->display_name = $request->get('role_name');
            //$role->org_id = auth()->user()->org_id;

            if ($role->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);

        }

    }

    public function roleDelete(Request $request)
    {
        //dd($request->id);
        $id = $request->id;
        $role = Role::find($id);
        if ($role)
            if ($role->delete())
                return response()->json(['success' => true]);
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
                <a href="#" type="button" class=" btn btn-icon-only green" onclick="fillForm(' . $table->id . ',\'' . $table->name . '\')"><i class="fa fa-edit"></i></a> 
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="roleDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /***********************************************
     **          Permission
     **
     **********************************************/
    public function permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض انواع الصلاحيات';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'اضافة نوع جديد';
        $this->data['menus'] = Menu::get();
        //dd($user);
        return view(role_vw() . '.permission')->with($this->data);
    }

    public function permissionStore(Request $request)
    {
        if ($request->hdn_permission_id == '') {
            $permission = New Permission();

            $permission->menu_id = $request->get('menu_id');
            $permission->name = $request->get('display_name');
            $permission->display_name = $request->get('display_name');
            $permission->screen_link = $request->get('screen_link');
            $permission->screen_order = $request->get('screen_order');


            if ($permission->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);
        } else {
            $permission = Permission::find($request->hdn_permission_id);
            $permission->menu_id = $request->get('menu_id');
            $permission->name = $request->get('display_name');
            $permission->display_name = $request->get('display_name');
            $permission->screen_link = $request->get('screen_link');
            $permission->screen_order = $request->get('screen_order');

            if ($permission->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);

        }

    }

    public function permissionDelete(Request $request)
    {
        //dd($request->id);
        $id = $request->id;
        $permission = Permission::find($id);
        if ($permission)
            if ($permission->delete())
                return response()->json(['success' => true]);
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
                <div class="col-md-12">
                <div class="col-md-2">
                <a href="#" type="button" class=" btn btn-icon-only green" onclick="fillForm(' . $table->id . ',\'' . $table->display_name . '\',' . $table->menu_id . ',\'' . $table->screen_link . '\',' . $table->screen_order . ')"><i class="fa fa-edit"></i></a>  
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="permDelete(\'' . $table->id . '\')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    public function menu()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض القوائم';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'اضافة قائمة جديد';

        //dd($user);
        return view(role_vw() . '.menu')->with($this->data);
    }

    public function menuStore(Request $request)
    {
        if ($request->hdn_menu_id == '') {
            $table = New Menu();

            $table->menu_name = $request->get('menu_name');
            $table->menu_display_name = $request->get('menu_display_name');
            $table->menu_icon = $request->get('menu_icon');
            $table->menu_order = $request->get('menu_order');
            //$role->org_id = auth()->user()->org_id;

            if ($table->save()) {
                return response()->json(['success' => true]);//return redirect()->to(role_vw() . '/');//

            } else
                return response()->json(['success' => false]);
        } else {
            $table = Menu::find($request->hdn_menu_id);
            $table->menu_name = $request->get('menu_name');
            $table->menu_display_name = $request->get('menu_display_name');
            $table->menu_icon = $request->get('menu_icon');
            $table->menu_order = $request->get('menu_order');
            if ($table->save()) {
                return response()->json(['success' => true]);

            } else
                return response()->json(['success' => false]);

        }

    }

    public function menuDelete(Request $request)
    {
        //dd($request->id);
        $id = $request->id;
        $table = Menu::find($id);
        if ($table)
            if ($table->delete())
                return response()->json(['success' => true]);
    }

    public function menuData()
    {
        $table = Menu::all();
        $num = 1;
        return datatables()->of($table)
            ->addColumn('num', function () use (&$num) {// user & as reference to store the privies value
                return $num++;
            })
            ->addColumn('action', function ($table) {// as foreach ($users as $user)

                return '
                <div class="col-md-6">
                <div class="col-md-2">
                <a href="#" type="button" class=" btn btn-icon-only green" 
 onclick="fillForm(' . $table->id . ',\'' . $table->menu_name . '\',\'' . $table->menu_display_name . '\',\'' . $table->menu_icon . '\',\'' . $table->menu_order . '\')"><i class="fa fa-edit"></i></a> 
                </div>
                <div class="col-md-2">
                <button type="button" class="btn btn-icon-only red" onclick="menuDelete(' . $table->id . ')"><i class="fa fa-times"></i></button></div></div>';
            })
            ->addColumn('menu_icon_desc', function ($table) {// as foreach ($users as $user)

                return '<i class="font-black ' . $table->menu_icon . ' "></i>';
            })
            ->rawColumns(['action'])
            ->rawColumns(['action', 'menu_icon_desc'])
            ->toJson();
    }

    public function role_permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض صلاحيات الفئات';
        $this->data['location_link'] = 'role';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'صلاحيات الفئات';
        $this->data['permissions'] = Permission::all();
        $this->data['roles'] = Role::all();
        //   $this->data['permission_role'] = Perm::all();
        //dd($user);
        return view(role_vw() . '.role_permission')->with($this->data);
    }

    public function user_permission()
    {
        $this->data['sub_menu'] = 'role';
        $this->data['location_title'] = 'عرض صلاحيات المستخدمين';
        $this->data['location_link'] = 'user_permission';
        $this->data['title'] = 'الصلاحيات';
        $this->data['page_title'] = 'صلاحيات المستخدمين';
        $this->data['emp'] = User::with('userEmployee')->get();
      //  dd($this->data['emp'] );
        $this->data['roles'] = Role::all();
        //dd($user);
        return view(role_vw() . '.user_permission')->with($this->data);
    }

    public function getPermissions(Request $request)
    {
        $id = $request->id;
        $pers = Permission::all();
        $role_pers = PermissionRole::where('role_id', $id)->get();
        //  dd($role_pers);
        $html = '';

        $selected = '';
        foreach ($pers as $per) {
            $selected = '';
            foreach ($role_pers as $role_per) {

                if ($role_per->permission_id == $per->id) {
                    //   dd('yes');
                    $selected = 'selected';
                }


            }
            $html .= '  <option value="' . $per->id . '"  ' . $selected . '>' . $per->display_name . '</option>';

        }

        return response()->json(['success' => true, 'per' => $html]);

    }

    public function deselectPer(Request $request)
    {
        $role_id = $request->role_id;
        $permission_id = $request->values[0];

        $perRole = PermissionRole::where('permission_id', $permission_id)
            ->where('role_id', $role_id)->delete();

        return response()->json(['success' => true]);
    }

    public function selectPer(Request $request)
    {
        //  dd($request->values[0]);
        $perRole = new PermissionRole();
        $perRole->role_id = $request->role_id;
        $perRole->permission_id = $request->values[0];
        if ($perRole->save())
            return response()->json(['success' => true, 'per' => $perRole]);

    }

    public function deselectUserPer(Request $request)
    {
        $user_id = $request->user_id;
        $permission_id = $request->values[0];

        $perRole = UserPermission::where('permission_id', $permission_id)
            ->where('user_id', $user_id)->delete();

        return response()->json(['success' => true]);
    }

    public function selectUserPer(Request $request)
    {

        $userPer = new UserPermission();
        $userPer->user_id = $request->user_id;
        $userPer->permission_id = $request->values[0];
        if ($userPer->save())
            return response()->json(['success' => true, 'per' => $userPer]);

    }
    public function getRolePermissions(Request $request)
    {
        $id = $request->id;
        $user_id = $request->user_id;

        // $pers=Permission::all();
        $role_pers = PermissionRole::with('permission')->where('role_id', $id)->get();
        $user_pers = UserPermission::with('permission')->where('user_id', $user_id)->get();
        // dd($role_pers);
        $html = '';

        $selected = '';

        foreach ($role_pers as $role_per) {
            //  dd($role_per->permissions);
            $selected = "";
            foreach ($user_pers as $user_per) {

                if ($user_per->permission->id == $role_per->permission->id) {

                    $selected = 'selected';

                }


            }
            $html .= '  <option value="' . $role_per->permission->id . '" ' . $selected . '>' . $role_per->permission->display_name . '</option>';
        }

       foreach ($user_pers as $user_per)
        {
            $selected = 'selected';
            $found = '';
            foreach ($role_pers as $role_per)
            {
                if ($user_per->permission->id == $role_per->permission->id)
                    $found = true;
            }
            if(!$found)
                $html .= '  <option value="' . $user_per->permission->id . '" ' . $selected . '>' . $user_per->permission->display_name . '</option>';

        }



        return response()->json(['success' => true, 'per' => $html]);

    }


}
