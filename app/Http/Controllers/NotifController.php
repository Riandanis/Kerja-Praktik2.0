<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;

class NotifController extends Controller
{
	protected $allNotif;
	public function __construct()
	{
		$this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");	
	}

}
