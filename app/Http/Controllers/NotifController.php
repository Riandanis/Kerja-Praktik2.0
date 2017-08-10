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
		$jumlah['action'] = DB::table('Actions')
			->join('diskusis','diskusis.id_diskusi','=','actions.id_diskusi')
			->join('topiks','topiks.id_topik','=','diskusis.id_topik')
			->join('agendas','agendas.id_agenda','=','topiks.id_agenda')
			->join('rapats','rapats.id_rapat','=','agendas.id_rapat')
			->where('Actions.status','=','0')
			->whereBetween('Actions.due_date',[$datenow,$datelast])
			->get();
		$jumlah['total'] = count($jumlah['action']);
		//dd($jumlah['action']);
		//dd($jumlah['total']); 
		$emails['pic'] = $jumlah['action'][0]->email_pic;
		$emails['leader'] = $jumlah['action'][0]->email_leader;
		dd($emails);
        Mail::send('notif',$jumlah,function($message) use ($emails){
            $message->from('dimas0308@gmail.com','ImesTelkom');
            $message->to($emails->pic)
            		->cc($emails->leader)
            ->subject('Deadline Action Rapat');
            });    
	}
	public function emailmom()
	{	
		$date = date('Y-m-d');
		$data['rapat'] = DB::table('rapats')
            ->where('rapats.waktu_rapat','like', $date.'%')
            ->orderBy('rapats.id_rapat')
            ->get();
 		//dd($data['rapat']);
        $email = $data['rapat'][0]->email_leader;
        //dd($email);
        $data['attendee'] = DB::table('rapats')
            ->join('attendees', 'rapats.id_rapat','=', 'attendees.id_rapat')
            ->where('rapats.id_rapat', '=', $data['rapat'][0]->id_rapat)
            ->get();
        //dd($data['attendee']);
        $data['agenda'] = DB::table('agendas')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $data['rapat'][0]->id_rapat)
            ->orderBy('agendas.id_agenda', 'ASC')
            ->get();
        //    dd($data['agenda']);
        $data['topik'] = DB::table('topiks')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $data['rapat'][0]->id_rapat)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        //dd($data['topik']);
        $data['diskusi'] = DB::table('diskusis')
            ->join('topiks', 'topiks.id_topik', '=','diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat','=',$data['rapat'][0]->id_rapat)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('diskusis.id_diskusi', 'ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        //dd($data['diskusi']);
        $data['action'] = DB::table('actions')
            ->join('diskusis', 'diskusis.id_diskusi','=', 'actions.id_diskusi')
            ->join('topiks', 'topiks.id_topik', '=', 'diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $data['rapat'][0]->id_rapat)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('diskusis.id_diskusi', 'ASC')
            ->orderBy('actions.id_action', 'ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        //dd($data['action']);
        $piece = explode(" ", $data['rapat'][0]->waktu_rapat);
        $tanggal_rapat = $piece[0];
        $waktu_rapat = explode(":",$piece[1])[0].":".explode(":",$piece[1])[1];
        $data['waktu'] = $waktu_rapat;
        $data['tanggal'] = $tanggal_rapat;
        //dd($data);
        Mail::send('momemail',$data,function($message) use ($email){
            $message->from('dimas0308@gmail.com','ImesTelkom');
            $message->to($email)
            ->subject('Deadline Action Rapat');
            });

	}
}
