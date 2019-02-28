<?php


namespace App;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class DealerAuth extends Authenticatable
{
    use HasApiTokens, Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard='DealerAuth-api';
    protected $fillable = [
        'id', 'retailer_id','dealer_code','firebase_token', 'password', 'created_at', 'updated_at'
    ];

    protected $table='dealer_authentication';


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}