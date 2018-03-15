<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = ['manufacturing_order_id','status','created_by','updated_by'];

    
    protected $table="tbl_manufacturing_status";

    public function Order(){
        return $this->belongsTo('App\Order','manufacturing_order_id');
    }

    static $a;
    public static function updated($v){
      Retailer::$a=$v;
    }
    public function user(){
      if(Retailer::$a==1){
            return $this->belongsTo("App\User",'updated_by');
      }
      return $this->belongsTo("App\User",'created_by');
    }
}
