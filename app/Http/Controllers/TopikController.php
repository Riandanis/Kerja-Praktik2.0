<?php

namespace App\Http\Controllers;

use DB;
use App\Topik;
use App\Diskusi;
use App\Action;
use Illuminate\Http\Request;

class TopikController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($rapat, $id)
    {
        //$rapat id_rapat, $id id_agenda
        $topik = DB::table('topiks')->where('id_agenda', '=', $id)->get();
        $agenda = DB::table('agendas')->select('id_agenda', 'id_rapat', 'nama_agenda')
                ->where('id_agenda', '=', $id)->first();

        return view('topik', ['topik'=>$topik, 'agenda'=>$agenda]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($rapat, $id)
    {
        $rapat = $rapat;
        $agenda = $id;
        return view('create-topik', ['agenda' => $agenda, 'rapat'=>$rapat]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $rapat, $id)
    {
        $id_rapat = $rapat;
        //insert topik
        $top = new Topik();
        $top->id_agenda = $id;
        $top->nama_topik = $request->input('topik');
        $top->save();

        //get id_topik
        $topik = $top->id_topik;
        
        //get value from form
        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $pic = $request->input('pic');
        $date = $request->input('due_date');
        // dd($diskusi, $action, $jenis, $pic, $date);

        // dd($ac[$i][$j]);
        // dd($diskusi[0]);
        if($diskusi[0]!=null){
            //insert diskusi
            $i = 0; 
            foreach($diskusi as $dis){
                $d = new Diskusi;
                $d->id_topik = $topik;
                $d->nama_diskusi = $dis;
                $d->save();

                $id_dis = $d->id_diskusi;

                if(count($action)){
                    $j = 0;

                    //insert action
                    foreach($action[$i] as $act){
                        $a = new Action;
                        $a->id_diskusi = $id_dis;
                        $a->deskripsi = $act;
                        $a->due_date = $date[$i][$j];
                        $a->email_pic = $pic[$i][$j];
                        $a->jenis_action = $jenis[$i][$j];

                        if($jenis[$i][$j] == 'Informasi'){
                            $a->status = 1;
                        }
                        else{
                            $a->status = 0;
                        }
                        $a->save();
                        $j++;
                    }
                }
                $i++;
            }
        }
        else{
            return redirect('agenda/'.$rapat);
        }
        return redirect('agenda/'.$rapat);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function show(Topik $topik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function edit(Topik $topik, $id)
    {
        $topik = DB::table('topiks')->where('id_topik', '=', $id)->get();
        return view('edit-topik', ['topik' => $topik]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Topik $topik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $del = Topik::find($id);
        $id_agenda = $del->id_agenda;
        $id_rapat = DB::table('agendas')->select('id_rapat')
                    ->where('id_agenda', '=', $id_agenda)->first();

        $del->delete();

    }
}

