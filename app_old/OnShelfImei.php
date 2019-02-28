<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnShelfImei extends Model {

    protected $fillable = ['id', 'task_id', 'item_id'];
    protected $table = 'tbl_on_shelf_imei';

    public function item()
    {
      return $this->belongsTo('App\Item', 'item_id');
    }

}
