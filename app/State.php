<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $table="tbl_state";
    public $timestamps = false;
    protected $fillable=['id', 'name'];
}
