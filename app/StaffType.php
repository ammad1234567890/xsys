<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffType extends Model
{
    protected $fillable=['type'];
    public function staff()
    {
      return $this->hasMany('App\Staff');
    }
    protected $table='tbl_staff_type';
}
