<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Ledger extends Model {

    protected $table = 'tbl_ledger';
    protected $fillable = ['invoice_id', 'retailer_id', 'collection_id', 'TransDate', 'description', 'Credit', 'Collection', 'is_reverse'];

    public function dealer_ledger($outlet_id) { 
        return DB::select("select DATE_FORMAT(x.TransDate,'%d-%m-%y %h:%i%p') as trans_date,FORMAT(x.Credit,2) as credit,FORMAT(x.Collection,2) as debit,x.description, (select FORMAT(SUM(
                                                COALESCE(Credit, 0) - COALESCE(Collection, 0)),2)  from tbl_ledger where retailer_id=$outlet_id) as outstanding
                                                from tbl_ledger as x where retailer_id=$outlet_id");
    }

}
//x.TransDate