<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssueItem extends Model
{
    protected $fillable=['warehouse_issue_id','item_id','created_by'];

    public function warehouseIssue()
    {
      return $this->belongsTo('App\WarehouseIssue');
    }

    public function item()
    {
      return $this->belongsTo('App\Item');
    }

    public function user()
    {
      return $this->belongsTo('App\User');
    }

    protected $table='tbl_warehouse_issue_items';
}
