<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeActiveSets extends Model
{
    protected $fillable=['id', 'item_id','activate_on' ,'created_by', 'created_at'];

    protected $table="deactive_sets";
}
