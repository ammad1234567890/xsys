<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RetailerInvoice extends Model {

    protected $table = "tbl_invoice";
    protected $fillable = ['id', 'order_id', 'discount_type_id', 'invoice_type_id', 'payment_type_id', 'total_amount', 'description', 'created_by', 'updated_by'];
    protected $primaryKey = 'id';
    
 public function payment_type()
    {
      return $this->belongsTo('App\PaymentType','payment_type_id');
    }
    public function invoice()
    {
      return $this->hasMany('App\RetailerInvoice','id');
    }
}
