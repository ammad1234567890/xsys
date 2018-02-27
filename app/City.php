<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    protected $table="tbl_city";
    public $timestamps = false;
    protected $fillable=['id', 'name', 'created_at', 'updated_at'];
}
