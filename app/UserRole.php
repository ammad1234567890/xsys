<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
  protected $fillable = [
      'role', 'description','created_by','updated_by'
  ];

  protected $table="tbl_user_role"
}
