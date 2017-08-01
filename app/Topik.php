<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topik extends Model
{
    protected $primaryKey = 'id_topik';
    public $incrementing = true;

    protected $fillable = [
    'id_topik', 'id_agenda', 'nama_topik'
    ];

    public function topik_agenda(){
    	return $this->belongsTo('App\Topik', 'id_agenda');
    }

    public function topik_diskusi(){
    	return $this->hasMany('App\Diskusi', 'id_topik');
    }
}
