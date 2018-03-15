<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseStaff extends Model
{
    protected $fillable=['warehouse_id','staff_id','created_by','updated_by','is_deleted'];

    public function warehouse()
    {
      return $this->belongsTo('App\Warehouse');
    }

    public function staff()
    {
      return $this->belongsTo('App\Staff');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    protected $table='tbl_warehouse_staff';
}
