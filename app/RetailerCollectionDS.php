<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerCollectionDS extends Model
{
    protected $fillable=['id','deposit_slip_number','total_amount','bank_id','currenct_id','payment_type_id','retailer_id','retailer_outlet_id','transaction_closed'];
    protected $table='tbl_retailer_collection_deposit_slip';

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

    public function get_ds_collections(){
        return $this->hasMany('App\RetailerCollection', 'collection_ds_id');
    }
}
