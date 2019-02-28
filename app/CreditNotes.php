<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNotes extends Model
{
    protected $fillable = ['id','cr_no','cr_type_id','retailer_id','outlet_id','amount', 'remarks'];
    protected $table="credit_notes";


    public function retailer()
    {
      return $this->belongsTo('App\Retailer', 'retailer_id');
    }

    public function retailer_outlet()
    {
      return $this->belongsTo('App\RetailerOutlet','outlet_id');
    }

    public function Cr_type()
    {
      return $this->belongsTo('App\CreditNoteTypes','cr_type_id');
    }

}
