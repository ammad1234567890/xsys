<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RetailerOrder extends Model
{
   protected $fillable=['id','retailer_id','sales_officer_id','outlet_id','order_date','expected_delivery_date','total_cost','remaining_payment','is_account_clearance','warehouse_id','is_deleted','retailer_order_status_id','created_by','updated_by'];
   protected $table="tbl_retailer_order";

    public function retailer()
    {
      return $this->belongsTo('App\Retailer');
    }

    public function retailer_outlet()
    {
      return $this->belongsTo('App\RetailerOutlet','outlet_id');
    }

    public function order_products(){
      return $this->hasMany('App\RetailerOrderProduct','retailer_order_id');
    }

    public function invoices(){
      return $this->hasMany('App\Invoice','order_id');
    }

    public function user(){
      return $this->belongsTo("App\User",'created_by');
    }
    public function updated_user(){
        return $this->belongsTo("App\User",'updated_by');
    }

     public function payment_type(){
        return PaymentType::all();
    }
        public function discount_type(){
        return Discount_type::all();
    }
}