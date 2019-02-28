<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssueNot extends Model
{
    protected $fillable=['id','warehouse_to','warehouse_from','is_approved', 'approved_by'];

    protected $table='warehouse_issue_note';


    public function warehouse_to()
    {
      return $this->belongsTo('App\Warehouse', 'warehouse_to');
    }

    public function warehouse_from()
    {
      return $this->belongsTo('App\Warehouse', 'warehouse_from');
    }

    public function approved_by(){
        return $this->belongsTo('App\User','approved_by');
    }

    public function transfer_products(){
        return $this->hasMany('App\WarehouseIssueNotItem','issue_note_id');
    }
	
	public function items(){
        return $this->hasMany('App\WarehouseIssueNoteImei','issue_note_id');
    }
}
