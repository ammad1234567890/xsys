<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $fillable = [
      'role', 'description','created_by','updated_by'
  ];

  public function users(){
    //make relations with user through tbl_user_role ware tbl_user_role.is_deleted is 0
    return $this->belongsToMany('App\User', 'tbl_user_role', 'user_id', 'role_id')->wherePivot('is_deleted', 0);
  }

  public function permission()
  {
    //make a relation with permission thorugh tbl_role_permission whre tbl_role_permission.is_deleted is 0
    return $this->belongsToMany('App\Permission', 'tbl_role_permission','role_id','permission_id')->wherePivot('is_deleted', 0);
  }

  protected $table="tbl_role";
}
