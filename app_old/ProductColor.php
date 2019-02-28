<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductColor extends Model
{
   protected $fillable=['sku','product_id','color','price','discount','is_deleted','created_by','updated_by'];

    public function product(){
      return $this->belongsTo('App\Product');
    }
	  public function invoiceProduct(){
        return $this->hasMany('App\InvoiceProduct');
    }
	
    public function mainWarehouseReceiveProduct(){
      return $this->hasMany('App\MainWarehouseReceiveProduct');
    }

    public function warehouseStock(){
      return $this->hasMany('App\warehouseStock');
    }

	  public function productColor() {
        return $this->hasMany('App\RetailerInvoice');
    }
    public function productImages()
    {
      return $this->hasMany('App\ProductImage');
    }

	public function product_colors($id) {
        return DB::table('tbl_product')
                        ->join('tbl_product_color', 'tbl_product_color.product_id', '=', 'tbl_product.id')
                        ->where(['tbl_product.id' => $id])
                        ->select('tbl_product_color.color', 'tbl_product_color.id')
                        ->get();
    }
	
    public function user()
    {
      return $this->belongsTo('App\User','created_by');
    }
	
   protected $table='tbl_product_color';
}
