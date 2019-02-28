<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealerNotification extends Model
{
    //
    protected $table="dealer_notification";
    protected $fillable=['id','notification_type','dealer_auth_id','data', 'read_at'];


}
