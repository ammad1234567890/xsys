<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerCollection extends Model
{
    //
    protected $table="tbl_retailer_collection";
    protected $fillable=['id','bank_id','currency_id','payment_type_id','retailer_id','retailer_outlet_id','invoice_id','cheque_number','amount','deposit_slip_number','remarks','created_by','updated_by'];

}

?>