<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecSubCategory extends Model
{
    protected $fillable=['id','specs_category_id','specs_sub_category_name'];
	protected $table='tbl_specs_sub_category';

	public function spec_cat()
    {
      return $this->belongsTo('App\SpecCategory','specs_category_id');
    }

    public function group_with_cat(){
    	return $this->groupBy('App\SpecCategory','specs_category_id');
    }

    public function sub_cat_specs(){
    	return $this->hasOne('App\SpecProduct','specs_sub_category_id');
    }
}