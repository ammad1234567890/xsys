<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $table="tbl_region";
    public $timestamps = true;
    protected $fillable=['id','city_id','name','created_at','updated_at'];

    public function city()
    {
    	return $this->belongsTo('App\City');
    }
}
