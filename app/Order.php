<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $table="tbl_manufacturing_order";
	protected $fillable = ['id','eta','total_cost','remaining_payment','created_by','updated_by'];

	public function manufacture_order_products(){
		return $this->hasMany('App\OrderProducts','manufacture_order_id');
	}

  public function payment(){
    return $this->hasMany('App\OrderPayment','manufacture_order_id');
  }

  public function order_status(){
    return $this->hasMany('App\OrderStatus','manufacturing_order_id');
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