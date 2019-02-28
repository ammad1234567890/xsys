<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineOrderProduct extends Model
{
    protected $table = "tbl_customer_order_products";
    protected $fillable = ['product_id', 'product_color_id', 'price', 'qty', 'order_id'];
}
