<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable=['designation'];

    public function staff()
    {
      return $this->hasMany('App\Staff');
    }
    protected $table='tbl_designation';
}
