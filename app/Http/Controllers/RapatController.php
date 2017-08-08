<?php

namespace App\Http\Controllers;

use DB;
use App\Rapat;
use App\Attendee;
use Illuminate\Http\Request;

class RapatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }
    public function index()
    {

        //return view('rapat.index');
        $rapat = DB::table('rapats')->orderBy('id_rapat')->paginate(25);
        return view('home', ['rapat'=>$rapat,'allNotif'=>$this->allNotif]);
    }


    public function rapat()
    {

        //return view('rapat.index');
        $rapat = DB::table('rapats')->orderBy('id_rapat')->paginate(25);
        return view('rapat', ['rapat'=>$rapat,'allNotif'=>$this->allNotif]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function renderRapat()
    {
        $allRapat = DB::table('rapats')
            ->select('id_rapat','headline', 'waktu_rapat')
            ->get();
        $events = array();
        foreach ($allRapat as $rapat) {
            $waktu = explode(" ", $rapat->waktu_rapat)[1];
            $e = array();
            $e['id'] = $rapat->id_rapat;
            $e['title'] = $rapat->headline;
            $e['start'] = $rapat->waktu_rapat;
            $e['end'] = $rapat->waktu_rapat;
            $e['allDay'] = false;

            array_push($events, $e);
        }

        return json_encode($events);
    }
    public function create()
    {
        return view('create-rapat',['allNotif'=>$this->allNotif]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tanggal = $request->input('tanggal_rapat');
        $jam = $request->input('waktu_rapat');
        $waktu = $tanggal . " " . $jam;

        $rapat = new Rapat();
        $rapat->headline = $request->input('headline');
        $rapat->waktu_rapat = $waktu;
        $rapat->tempat_rapat = $request->input('tempat');
        $rapat->save();

        $peserta = $request->input('peserta');

        $id = $rapat->id_rapat;
        if(count($peserta)){
            foreach($peserta as $p){
                $pes = new Attendee();
                $pes->id_rapat = $id;
                $pes->ket_attendee = $p;
                $pes->save();
            }
        }

        return redirect ('/home',['allNotif'=>$this->allNotif]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rapat  $rapat
     * @return \Illuminate\Http\Response
     */
    public function show(Rapat $rapat)
    {
        return view('detil_rapat.create',['allNotif'=>$this->allNotif]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rapat  $rapat
     * @return \Illuminate\Http\Response
     */
    public function edit(Rapat $rapat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rapat  $rapat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rapat $rapat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rapat  $rapat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rapat $rapat)
    {
        //
    }
}
