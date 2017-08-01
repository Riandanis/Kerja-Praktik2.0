<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $primaryKey = 'id_action';
    public $incrementing = true;

    protected $fillable = [
    'id_action', 'id_diskusi', 'deskripsi', 'due_date', 'email_pic', 
    'jenis_action', 'solusi', 'status'
    ];

    public function action_diskusi(){
    	return $this->belongsTo('App\Action', 'id_diskusi');
    }
}
