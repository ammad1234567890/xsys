<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerOrderProduct extends Model
{
   protected $fillable=['id','retailer_order_id','product_color_id','product_qty','unit_price','total_price','is_deleted','created_by','updated_by'];
   protected $table="tbl_retailer_order_products";

   public function order()
    {
      return $this->belongsTo('App\RetailerOrder','retailer_order_id');
    }

    public function ProductColor(){
      return $this->belongsTo('App\ProductColor');
   }

   public function products_qty_sum($query){
      return $query->sum('product_qty');
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