<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    protected $fillable = ['id','type','created_by','updated_by'];
    protected $table="tbl_payment_type";
}
