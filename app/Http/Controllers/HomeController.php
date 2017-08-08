<?php

namespace App\Http\Controllers;

use App\Rapat;
use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
use DB;
use Illuminate\Support\Facades\App;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function pdfgen($id)
    {
        $rapat = DB::table('rapats')
            ->where('rapats.id_rapat','=', $id)
            ->orderBy('rapats.id_rapat')
            ->get();
        $attendee = DB::table('rapats')
            ->join('attendees', 'rapats.id_rapat','=', 'attendees.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->get();
        $agenda = DB::table('agendas')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->orderBy('agendas.id_agenda', 'ASC')
            ->get();
        $topik = DB::table('topiks')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        $diskusi = DB::table('diskusis')
            ->join('topiks', 'topiks.id_topik', '=','diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat','=',$id)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('diskusis.id_diskusi', 'ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        $action = DB::table('actions')
            ->join('diskusis', 'diskusis.id_diskusi','=', 'actions.id_diskusi')
            ->join('topiks', 'topiks.id_topik', '=', 'diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->orderBy('agendas.id_agenda','ASC')
            ->orderBy('topiks.id_topik','ASC')
            ->orderBy('diskusis.id_diskusi', 'ASC')
            ->orderBy('actions.id_action', 'ASC')
            ->orderBy('rapats.id_rapat')
            ->get();
        $piece = explode(" ", $rapat[0]->waktu_rapat);
        $tanggal_rapat = $piece[0];
        $waktu_rapat = explode(":",$piece[1])[0].":".explode(":",$piece[1])[1];
//        dd($agenda, $topik, $diskusi, $action);
//        $pdf=PDF::loadview('newpdf', [''])
        return view ('newpdf', ['attendee'=>$attendee, 'rapat'=>$rapat, 'agenda'=>$agenda, 'topik'=>$topik, 'diskusi'=>$diskusi, 'action'=>$action,'tanggal_rapat'=>$tanggal_rapat, 'waktu_rapat'=>$waktu_rapat]);
    }

    public function pdf()
    {
        $rapat = DB::table('rapats')
            ->where('rapats.id_rapat','=', $id)
            ->get();
        $attendee = DB::table('rapats')
            ->join('attendees', 'rapats.id_rapat','=', 'attendees.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->get();
        $agenda = DB::table('agendas')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->get();
        $topik = DB::table('topiks')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->get();
        $diskusi = DB::table('diskusis')
            ->join('topiks', 'topiks.id_topik', '=','diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat', '=', 'agendas.id_rapat')
            ->where('rapats.id_rapat','=',$id)
            ->get();
        $action = DB::table('actions')
            ->join('diskusis', 'diskusis.id_diskusi','=', 'actions.id_diskusi')
            ->join('topiks', 'topiks.id_topik', '=', 'diskusis.id_topik')
            ->join('agendas', 'agendas.id_agenda', '=', 'topiks.id_agenda')
            ->join('rapats', 'rapats.id_rapat','=', 'agendas.id_rapat')
            ->where('rapats.id_rapat', '=', $id)
            ->get();
        $piece = explode(" ", $rapat[0]->waktu_rapat);
        $tanggal_rapat = $piece[0];
        $waktu_rapat = $piece[1];
        return view ('pdf');
    }
}
