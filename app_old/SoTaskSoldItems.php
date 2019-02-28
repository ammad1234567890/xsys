<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoTaskSoldItems extends Model {

    protected $fillable = ['id', 'task_id', 'item_id'];
    protected $table = 'tbl_so_task_sold_items';

}
