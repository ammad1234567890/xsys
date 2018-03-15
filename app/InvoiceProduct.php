<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProduct extends Model
{
    //
    protected $table="tbl_invoice_products";
    protected $fillable=['id','invoice_id','product_color_id','product_qty','product_price','is_deleted','created_by','updated_by'];

    public function invoice()
    {
      return $this->belongsTo('App\Invoice');
    }

    public function productColor()
    {
      return $this->belongsTo('App\ProductColor');
    }
}

?>