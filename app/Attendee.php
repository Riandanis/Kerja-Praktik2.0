<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{
    protected $primaryKey = 'id_attendee';
    public $incrementing = true;

    protected $fillable = [
    'id_attendee', 'id_rapat', 'ket_attendee'
    ];

    public function attendee_rapat(){
    	return $this->belongsTo('App\Rapat', 'id_rapat');
    }
}
