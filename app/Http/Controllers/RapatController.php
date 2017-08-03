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
    public function index()
    {
        return view ('home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function renderRapat()
    {
        $allRapat = DB::table('rapats')
            ->select('headline', 'waktu_rapat')
            ->get();
//        dd($allRapat);
        return json_encode($allRapat);
    }
    public function create()
    {
        return view('rapat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $jam = $request->input('jam');
        $waktu = $tanggal . " " . $jam;

        $rapat = new Rapat();
        $rapat->headline = $request->input('headline');
        $rapat->waktu_rapat = $waktu;
        $rapat->tempat_rapat = $request->input('tempat');
        $rapat->save();

        $attendee = $request->input('attendee');
        $peserta = $request->input('peserta');

        $id = $rapat->id_rapat;
        $att = new Attendee();
        $att->id_rapat = $id;
        $att->ket_attendee = $attendee;
        $att->save();

        if(count($peserta)){
            foreach($peserta as $p){
                $pes = new Attendee();
                $pes->id_rapat = $id;
                $pes->ket_attendee = $p;
                $pes->save();
            }    
        }
        
        // dd($request);
        return redirect ('/rapatnya');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rapat  $rapat
     * @return \Illuminate\Http\Response
     */
    public function show(Rapat $rapat)
    {
        return view('detil_rapat.create');
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
