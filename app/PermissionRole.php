<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table='permission_role';
  //  protected $primaryKey='';
    //
    function permission()
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }
    function roles()
    {
        return $this->belongsTo(Role::class,'role_id','id');
    }
}
