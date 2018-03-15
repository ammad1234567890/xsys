<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveProducts extends Model
{
   protected $fillable=['receive_id','product_color_id','product_qty','created_by','updated_by'];
   protected $table="tbl_receive_products";

   public function Receive(){
   		return $this->belongsTo('App\Receive','receive_id');
   }

   public function ProductColor(){
   		return $this->belongsTo('App\ProductColor');
   }
}