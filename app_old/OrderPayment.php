<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['manufacture_order_id','payment_amount','total_amount','payment_type_id','currency_id','exchange_rate','created_by','updated_by','is_deleted'];

    
    protected $table="tbl_manufacturing_payment";

    public function Order(){
        return $this->belongsTo('App\Order');
    }

    public function payment_type(){
        return $this->belongsTo('App\PaymentType','payment_type_id');
    }

    public function currency(){
        return $this->belongsTo('App\Currency','currency_id');
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
