<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    protected $primaryKey = 'id_diskusi';
    public $incrementing = true;

    protected $fillable = [
    'id_diskusi', 'id_topik', 'nama_diskusi'
    ];

    public function diskusi_topik(){
    	return $this->belongsTo('App\Diskusi', 'id_topik');
    }

    public function diskusi_rapat(){
    	return $this->hasMany('App\Action', 'id_diskusi');
    }
}
