<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineOrder extends Model
{
    protected $table = "tbl_customer_orders";
    protected $fillable = ['fullname', 'phone', 'email', 'address','status', 'name', 'updated_at', 'created_at'];
}
