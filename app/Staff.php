<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['name','email','CNIC','address','city_id','region_id','department_id','staff_type_id','designation_id','created_by','updated_by'];

    public function city()
    {
      return $this->belongsTo('App\City','city_id');
    }

    public function region()
    {
      return $this->belongsTo('App\Region','region_id');
    }

    public function department()
    {
      return $this->belongsTo('App\Department','department_id');
    }

    public function staffType()
    {
      return $this->belongsTo('App\StaffType','staff_type_id');
    }

    public function designation()
    {
      return $this->belongsTo('App\Designation','designation_id');
    }

    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }

    protected $table="tbl_staff";
}
