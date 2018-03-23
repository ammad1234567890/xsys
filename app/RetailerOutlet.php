<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerOutlet extends Model
{
    //
    protected $table="tbl_retailer_outlet";
    protected $fillable=['retailer_id','city_id','region_id','name','latitude','longitude','address','phone_no','business_person_name','mobile_no','business_person_cnic','security_deposit_amount','security_deposit_image','credit_limit','credit_duration','credit_remaining','aging_amount','is_deleted','created_by','updated_by'];

    public function retailer()
    {
      return $this->belongsTo('App\Retailer');
    }
    public function city()
    {
      return $this->belongsTo('App\City');
    }
    public function region()
    {
      return $this->belongsTo('App\Region');
    }
    public function retailer_order()
    {
      return $this->hasMany('App\RetailerOrder','outlet_id');
    }

    static $a;
    public static function updated($v){
      Retailer_outlet::$a=$v;
    }
    public function user(){
      if(Retailer_outlet::$a==1){
            return $this->belongsTo("App\User",'updated_by');
      }
      return $this->belongsTo("App\User",'created_by');
    }
}
