<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $table = 'tbl_ledger';
    protected $fillable = ['invoice_id','retailer_id','collection_id','TransDate','description','Credit','Collection'];
}
