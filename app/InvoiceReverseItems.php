<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceReverseItems extends Model
{
    protected $fillable=['warehouse_issue_id','item_id','created_by'];

      public function warehouseIssue()
    {
    //  return $this->belongsTo('App\WarehouseIssue');
	      return $this->belongsTo('App\WarehouseIssue','warehouse_issue_id');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    protected $table='tbl_invoice_reverse_items';
}
