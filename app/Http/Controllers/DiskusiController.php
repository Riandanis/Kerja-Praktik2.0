<?php

namespace App\Http\Controllers;

use App\Diskusi;
use Illuminate\Http\Request;

class DiskusiController extends Controller
{
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }
   
}
