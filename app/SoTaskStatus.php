<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SoTaskStatus extends Model {

    protected $fillable = ['id', 'name'];
    protected $table = 'tbl_so_task_status';



}
