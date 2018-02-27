<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    //
    protected $table="tbl_region";
    public $timestamps = true;
    protected $fillable=['id', 'name','created_at','updated_at'];
}
