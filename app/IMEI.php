<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IMEI extends Model
{
   protected $fillable=['imei1','imei2','created_by','item_id','product_id'];

   protected $table="tbl_imei";

   public function item()
   {
     return $this->belongsTo('App\item');
   }

   public function product()
   {
   	return $this->belongsTo('App\product');
   }
}
