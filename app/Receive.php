<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receive extends Model
{
   protected $fillable=['manufacturing_order_id','collected_by','is_qa_pass','qa_description','receive_status_id','created_by','updated_by'];
   protected $table="tbl_receive";
}