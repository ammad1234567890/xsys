<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    //
    protected $table="tbl_invoice";
    protected $fillable=['id','order_id','discount_type_id','invoice_type_id','discount_percent','discount_amount','description','created_by','updated_by'];

    public function order()
    {
    	return $this->belongsTo('App\RetailerOrder');
    }

    public function discountType()
    {
    	return $this->belongsTo('App\Discount_type');
    }

    public function invoiceType()
    {
    	return $this->belongsTo('App\InvoiceType');
    }

    public function invoiceProduct()
    {
      return $this->hasMany('App\InvoiceProduct');
    }
    
}

?>