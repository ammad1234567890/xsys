<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteTypes extends Model
{
    protected $fillable = ['id','name'];
    protected $table="credit_note_types";
}
