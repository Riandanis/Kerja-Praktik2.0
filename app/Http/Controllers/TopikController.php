<?php

namespace App\Http\Controllers;

use DB;
use App\Topik;
use App\Diskusi;
use App\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

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

                if($action[$i][0]!=null){
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
    public function edit($id)
    {
        $topik = DB::table('topiks')->where('id_topik', '=', $id)->get();
        return view('edit-topik', ['topik'=>$topik, 'id'=>$id]);
    }

    public function renderAll ()
    {
        $id = Input::get('idtop');
        $data = array();
        $data['topik'] = DB::table('topiks')->where('id_topik','=', $id)->get();
        $data['diskusi'] = DB::table('topiks')
            ->join('diskusis', 'diskusis.id_topik','=','topiks.id_topik')
            ->where('topiks.id_topik','=',$id)
            ->get();

        $data['action'] = DB::table('topiks')
            ->join('diskusis', 'diskusis.id_topik', '=', 'topiks.id_topik')
            ->join('actions', 'actions.id_diskusi','=', 'diskusis.id_diskusi')
            ->where('topiks.id_topik','=',$id)
            ->get();
        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Topik  $topik
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //update topik
        $edit_top = Topik::where('id_topik', $id)->first();
        $edit_top->nama_topik = $request->input('topik');
        $edit_top->save();

        $id_topik = $id;
        $nama_topik = $request->input('topik');
        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $pic = $request->input('pic');
        $date = $request->input('due_date');

        //nambah diskusi
        $i = 0;
        foreach($diskusi as $d){
            $edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                                ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            // $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;
        }$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;
            $edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;$edit_d = Diskusi::where('nama_diskusi', $d)
                    ->where('id_topik', $id)->first();
            if($edit_d==null){
                $baru = new Diskusi();
                $baru->id_topik = $id;
                $baru->nama_diskusi = $edit_d;
                $baru->save(); 

                $id_d = $baru->id_diskusi;

                //insert action
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis_action[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }

                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            else{
                $id_d = $edit_d->id_diskusi;
                $j=0;
                foreach($action[$i] as $act){
                    if($act!=null){
                        $edit_a = Action::where('deskripsi', $act)
                            ->where('id_diskusi', $id_d)->first();
                        if($edit_a==null){
                            $new = new Action();
                            $new->id_diskusi = $id_d;
                            $new->deskripsi = $act;
                            $new->due_date = $date[$i][$j];
                            $new->email_pic = $pic[$i][$j];

                            if($jenis[$i][$j]=='keterangan'){
                                $new->jenis_action = 'Informasi';
                                $new->status = 1;
                            }
                            else{
                                $new->jenis_action = $jenis[$i][$j];
                                if($jenis[$i][$j] == 'Informasi'){
                                    $new->status = 1;
                                }
                                else{
                                    $new->status = 0;
                                }
                            }
                            $new->save();
                        }    
                        else{
                            // dd($date[$i][$j]);
                            $edit_a->due_date = $date[$i][$j];
                            $edit_a->email_pic = $pic[$i][$j];
                            $edit_a->jenis_action = $jenis[$i][$j];
                            if($jenis[$i][$j] == 'Informasi'){
                                $edit_a->status = 1;
                            }
                            else{
                                $edit_a->status = 0;
                            }
                            $edit_a->save();
                        }
                    }
                    $j++;
                }
                $act = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $action[$i])
                        ->get();
                foreach($act as $dba){
                    $dba->delete();
                }
            }
            $i++;
            
        //apus diskusi yg udah ga ada
        $disk = Diskusi::where('id_topik', $id)
                ->whereNotIn('nama_diskusi', $diskusi)
                ->get();
        foreach($disk as $db){
            $db->delete();
        }

        return redirect('topik/edit'.$id);
        // dd($nama_topik, $diskusi, $action, $jenis, $pic, $date);
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

