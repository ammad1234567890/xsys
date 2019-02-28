<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingleProductImages extends Model
{
    //
    protected $table="tbl_single_product_image";
    protected $fillable=['id','product_id','image','image_type'];

    
}

?>