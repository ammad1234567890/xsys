<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['id','name','iso','exchange_rate','created_by','updated_by'];
    protected $table="tbl_currency";
}
