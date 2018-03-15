<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discount_type extends Model
{
    //
    protected $table="tbl_discount_type";
    protected $fillable=['id','discount_name','is_deleted','created_by','updated_by'];
}

?>