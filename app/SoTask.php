<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class SoTask extends Model {

    protected $fillable = ['id', 'so_id', 'task_no','outlet_id', 'status_id', 'created_by', 'created_at', 'updated_at'];
    protected $table = 'tbl_so_task';

    public function tasks($so_id) {
        return DB::table('tbl_so_task')->select('tbl_retailer_outlet.name as outlet_name', 'tbl_retailer_outlet.address'
                                , 'tbl_so_task.id', 'tbl_so_task.outlet_id as outlet_id', 'tbl_so_task.status_id as status','tbl_so_task.task_no')
                        ->join('tbl_retailer_outlet', 'tbl_retailer_outlet.id', '=', 'tbl_so_task.outlet_id')
                        ->where(['so_id' => $so_id])
                        ->get();
    }

    public function sales_officer(){
    	return $this->belongsTo('App\Staff', 'so_id');
    }
    public function retailer_outlet()
    {
      return $this->belongsTo('App\RetailerOutlet','outlet_id');
    }

    public function task_status()
    {
      return $this->belongsTo('App\SoTaskStatus','status_id');
    }

}
