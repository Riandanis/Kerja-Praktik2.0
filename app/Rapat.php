<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rapat extends Model
{
    protected $primaryKey = 'id_rapat';
    public $incrementing = true;

    protected $fillable = [
    'id_rapat', 'headline', 'waktu_rapat', 'tempat_rapat'
    ];
}
