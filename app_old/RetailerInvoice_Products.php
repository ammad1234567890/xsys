<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RetailerInvoice_Products extends Model {

    protected $table = "tbl_invoice_products";
    protected $fillable = ['id', 'invoice_id', 'product_color_id', 'product_qty', 'product_price', 'discount_type_id', 'total_amount', 'extra', 'is_deleted', 'created_by', 'updated_by'];
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function invoice_Products() {
        return $this->belongsTo('App\RetailerInvoice', 'invoice_id');
    }

    public function productColor() {
        return $this->belongsTo('App\ProductColor', 'product_color_id');
    }

}
