<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $primaryKey = 'id_agenda';
    public $incrementing = true;

    protected $fillable = [
    'id_agenda', 'id_rapat', 'nama_agenda'
    ];

    public function agenda_rapat(){
    	return $this->belongsTo('App\Rapat', 'id_rapat');
    }

    public function agenda_topik(){
    	return $this->hasMany('App\Topik', 'id_agenda');
    }
}
