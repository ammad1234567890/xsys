<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SpecCategory extends Model
{
    protected $fillable=['id','specs_category_name'];
	protected $table='tbl_specs_category';

	public function sub_cat()
    {
        return $this->hasMany('App\SpecSubCategory', 'specs_category_id');
    }
}