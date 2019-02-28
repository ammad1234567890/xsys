<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WarehouseIssueNoteImei extends Model
{
    protected $fillable=['id','issue_note_id', 'item_id', 'imei'];

    protected $table='warehouse_issue_note_imei';
    public $timestamps = false;
	
	public function item(){
        return $this->belongsTo('App\Item','item_id');
    }



}
