<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProducts extends Model
{
   protected $fillable=['product_color_id','manufacture_order_id','quantity','remaining_qty','unit_cost','created_by','updated_by'];
   protected $table="tbl_manufacturing_order_product";

   public function Order(){
   		return $this->belongsTo('App\Order');
   }

   public function ProductColor(){
   		return $this->belongsTo('App\ProductColor');
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
