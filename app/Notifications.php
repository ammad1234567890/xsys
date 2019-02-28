<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    protected $fillable=['id','type', 'notifiable_id', 'notifiable_type', 'data', 'read_at'];

    protected $table="notifications";
}
