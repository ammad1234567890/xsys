<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecProduct extends Model
{
    protected $fillable=['id','specs_sub_category_id','product_id','detail_name'];
    public $timestamps = false;
	protected $table='tbl_specs_product';

	public function spec_sub_cat()
    {
      return $this->belongsTo('App\SpecSubCategory','specs_sub_category_id');
    }

}