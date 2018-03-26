<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RetailerInvoice extends Model {

    protected $table = "tbl_invoice";
    protected $fillable = ['id','invoice_no' ,'order_id', 'discount_type_id', 'invoice_type_id', 'payment_type_id', 'total_amount', 'description', 'created_by', 'updated_by'];
    protected $primaryKey = 'id';
    
 public function payment_type()
    {
      return $this->belongsTo('App\PaymentType','payment_type_id');
    }
    public function invoice()
    {
      return $this->hasMany('App\RetailerInvoice','id');
    }
     public function RetailerOrder()
    {
      return $this->belongsTo('App\RetailerOrder','order_id');
    }
       public function outlet()
    {
      return $this->belongsTo('App\RetailerOutlet','retailer_id');
    }
	   public function warehouse_issue(){
         return $this->hasMany('App\WarehouseIssue','invoice_id');
    }
        public function warehouse_issue_item(){
         return $this->hasMany('App\WarehouseIssueItem','id','warehouse_id');
    }
    
}
