<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveStatus extends Model
{
   protected $fillable=['status','created_by','updated_by'];
   protected $table="tbl_receive_status";
}