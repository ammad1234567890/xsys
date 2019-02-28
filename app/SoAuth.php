<?php

namespace App;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SoAuth extends Authenticatable
{
	use HasApiTokens, Notifiable;
    protected $fillable=['id','so_id','password','firebase_token'];
	protected $table='tbl_so_auth';
}
