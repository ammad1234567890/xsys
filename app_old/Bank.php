<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
   protected $fillable=['id','city_id','bank_name','bank_uan','order_date'];
   protected $table="tbl_bank";
}
?>