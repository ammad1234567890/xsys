<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssue extends Model
{
   protected $fillable=['invoice_id','invoice_no','warehouse_id','is_issued','created_by'];

   public function warehouse()
   {
     return $this->belongsTo('App\warehouse');
   }

   public function user()
   {
     return $this->belongsTo('App\User','created_by');
   }

    public function invoice()
    {
      return $this->belongsTo('App\Invoice');
    }

   public function warehouseIssueItem()
   {
     return $this->hasMany('App\WarehouseIssueItem');
   }

   protected $table='tbl_warehouse_issue';
}
