<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssueReturn extends Model {

    protected $fillable = ['id', 'invoice_id', 'warehouse_id', 'item_id', 'created_at'];
    protected $table = 'tbl_warehouse_issue_return';

}
