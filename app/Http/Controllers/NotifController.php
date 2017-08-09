<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Illuminate\Http\Request;

class NotifController extends Controller
{
	protected $allNotif;
	public function __construct()
	{
		$this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");	
	}
	public function email()
	{
		$datelast = date('Y-m-d',strtotime("+3 days"));
		$datenow = date('Y-m-d');
		$dk = DB::table('Actions')
			->where('Actions.status','=','0')
			->whereBetween('Actions.due_date',[$datenow,$datelast])
			->get();
		if(count($dk) > 0){
			$emails = array();
            $jumlah = array(
                'banyak'=>count($dk),
                'deskripsi' => $deskripsi = array(),
            );
        foreach ($dk as $tmp) {
            array_push($jumlah['deskripsi'],$tmp->deskripsi);
            array_push($emails,$tmp->email_pic);
        }

        Mail::send('coba',$jumlah,function($message) use ($emails){
            $message->from('dimas0308@gmail.com','ImesTelkom');
            $message->to($emails)
            ->subject('Deadline Action Rapat');
            });    
        }
	}
}
