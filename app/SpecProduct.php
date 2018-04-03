<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecProduct extends Model
{
    protected $fillable=['id','specs_category_id','specs_sub_category_id','product_id','detail_name'];
	protected $table='tbl_specs_product';
}