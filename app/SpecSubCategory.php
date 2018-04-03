<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecSubCategory extends Model
{
    protected $fillable=['id','specs_sub_category_name'];
	protected $table='tbl_specs_sub_category';
}