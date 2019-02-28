<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssueNotItem extends Model
{
    protected $fillable=['id','issue_note_id','product_id','product_color_id', 'quantity', 'price'];

    protected $table='warehouse_issue_note_items';
    public $timestamps = false;

    public function product(){
        return $this->belongsTo('App\Product','product_id');
    }


	public function product_color(){
        return $this->belongsTo('App\ProductColor','product_color_id');
    }

}
