<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
  protected $fillable = [
      'role_id','permission_id'
  ];

  protected $table="tbl_role_permission";
}
