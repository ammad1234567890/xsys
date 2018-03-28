<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
   protected $fillable=['manufacturing_order_id','collected_by','is_qa_pass','qa_description','receive_status_id','created_by','updated_by'];
   protected $table="tbl_receive";

   public function Staff(){
   		return $this->belongsTo('App\Staff','collected_by');
   }

   public function ReceiveStatus(){
   		return $this->belongsTo('App\ReceiveStatus','receive_status_id');
   }

   public function Order(){
      return $this->belongsTo('App\Order','manufacturing_order_id');
   }
   
   public function ReceiveProducts(){
   		return $this->hasMany('App\ReceiveProducts','receive_id');
   }

   public function mainWarehouseReceive(){
    return $this->hasOne('App\MainWarehouseReceive');
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