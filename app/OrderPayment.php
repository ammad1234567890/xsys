<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = ['manufacture_order_id','payment_amount','total_amount','payment_type_id','currency_id','exchange_rate','created_by','updated_by','is_deleted'];

    
    protected $table="tbl_manufacturing_payment";
}
