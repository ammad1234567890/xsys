<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
  protected $fillable = [
      'permission', 'description', 'url'
  ];

public function role()
{
  return $this->belongsToMany('App\Role', 'tbl_role_permission','role_id','permission_id')->wherePivot('is_deleted', 0);
}
  protected $table="tbl_permission";
}
