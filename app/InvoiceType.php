<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_type extends Model
{
    //
    protected $table="tbl_invoice_type";
    protected $fillable=['id','invoice_name','is_deleted','created_by','updated_by'];
}

?>