<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerCollection extends Model
{
    //
    protected $table="tbl_retailer_collection";
    protected $fillable=['id','bank_id','currency_id','payment_type_id','is_reversible','retailer_id','retailer_outlet_id','invoice_id','cheque_number','amount','deposit_slip_number','remarks','created_by','updated_by'];

    public function bank(){
        return $this->belongsTo('App\Bank','bank_id');
    }

    public function currency(){
        return $this->belongsTo('App\Currency','currency_id');
    }

    public function payment_type(){
        return $this->belongsTo('App\PaymentType','payment_type_id');
    }

    public function retailer_outlet(){
        return $this->belongsTo('App\RetailerOutlet','retailer_outlet_id');
    }

    public function retailer(){
        return $this->belongsTo('App\Retailer','retailer_id');
    }

    public function invoice(){
        return $this->belongsTo('App\Invoice','invoice_id');
    }

}

?>