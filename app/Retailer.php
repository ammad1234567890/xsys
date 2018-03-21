<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Retailer extends Model
{
    //
    protected $table="tbl_retailer";
    protected $fillable=['name','retailer_no','cnic','phone_no','image','is_deleted','created_by','updated_by','created_at','updated_at'];

    public function retailer_outlet()
    {
      return $this->hasMany('App\RetailerOutlet');
    }

    public function retailer_order()
    {
      return $this->hasMany('App\Retailer_order');
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
