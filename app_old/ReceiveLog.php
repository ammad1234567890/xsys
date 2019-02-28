<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReceiveLog extends Model
{
   protected $fillable=['recieve_id','recieve_status_id','created_by','updated_by'];
   protected $table="tbl_receive_status_log";
}