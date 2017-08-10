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
   
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }

    public function index($rapat, $id)
    {
        
    }

    public function create($rapat, $id)
    {
        $rapat = $rapat;
        $agenda = $id;
        return view('create-topik', ['agenda' => $agenda, 'rapat'=>$rapat, 'allNotif'=>$this->allNotif]);
    }

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
       

        if($diskusi[0]!=null){
            //insert diskusi
            $i = 0; 
            foreach($diskusi as $dis){
                $d = new Diskusi;
                $d->id_topik = $topik;
                $d->nama_diskusi = $dis;
                $d->save();

                $id_dis = $d->id_diskusi;

                if($action[$i][0]!=null Or !(array_key_exists(0, $action[$i]))){
                    $j = 0;

                    //insert action
                    foreach($action[$i] as $act){
                        $a = new Action;
                        $a->id_diskusi = $id_dis;
                        $a->deskripsi = $act;
                        

                        if($jenis[$i][$j] == 'Target'){
                            $a->status = 0;
                            $a->jenis_action = 'Target';
                            $a->email_pic = $pic[$i][$j];
                            $a->due_date = $date[$i][$j];
                        }
                        else{
                            $a->status = 1;
                            $a->jenis_action = 'Informasi';
                            $a->email_pic = 'example@email.com';
                            $a->due_date = null;
                        }

                        $a->save();
                        $j++;
                    }
                }

                else{
                    $a = new Action;
                    $a->id_diskusi = $d->id_diskusi;
                    $a->deskripsi = 'Tidak Ada Action';
                    $a->jenis_action = 'Informasi';
                    $a->email_pic = 'example@email.com';
                    $a->status = 1;

                    $a->save(); 
                }

                $i++;
            }
        }
        else{
            $d = new Diskusi;
            $d->id_topik = $topik;
            $d->nama_diskusi = 'Tidak Ada Diskusi';
            $d->save();

            $a = new Action;
            $a->id_diskusi = $d->id_diskusi;
            $a->deskripsi = 'Tidak Ada Action';
            $a->jenis_action = 'Informasi';
            $a->email_pic = 'example@email.com';
            $a->status = 1;

            $a->save();

            return redirect('agenda/'.$rapat);
        }
        return redirect('agenda/'.$rapat);
    }

   
    public function show(Topik $topik)
    {
        //
    }

    
    public function edit($id)
    {
        $topik = DB::table('topiks')->where('id_topik', '=', $id)->get();

        return view('edit-topik', ['topik'=>$topik, 'id'=>$id,'allNotif'=>$this->allNotif]);
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

    public function update(Request $request, $id)
    {
        //edit topik
        $edit_top = Topik::where('id_topik', $id)->first();
        $edit_top->nama_topik = $request->input('topik');
        $edit_top->save();

        $id_topik = $id;

        //ambil input
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $pic = $request->input('pic');
        $date = $request->input('due_date');
        $nama_topik = $request->input('topik');
        $diskusi = $request->input('diskusi');
        // dd($action);
        if(count($diskusi)==1 and $diskusi[0]==null){
            // dd($diskusi);
            $d = new Diskusi;
            $d->id_topik = $id_topik;
            $d->nama_diskusi = 'Tidak Ada Diskusi';
            $d->save();
            $id_d = $d->id_diskusi;

            $a = new Action;
            $a->id_diskusi = $id_d;
            $a->deskripsi = 'Tidak Ada Action';
            $a->jenis_action = 'Informasi';
            $a->email_pic = 'example@email.com';
            $a->status = 1;
            $a->save();
        }
        else{
            $i = 0;
            $dis = array();
            foreach($diskusi as $d){
                if(array_key_exists($i, $diskusi)){
                    if($d!=null){
                        $edit_d = Diskusi::where('nama_diskusi', $d)
                                ->where('id_topik', $id_topik)->first();

                        if($edit_d == null){
                            $new = new Diskusi();
                            $new->id_topik = $id_topik;
                            $new->nama_diskusi = $d;
                            if($new->save()){
                                $flag = 1;
                                $id_d = $new->id_diskusi;
                            }
                            else{
                                $flag = 0;
                            }
                        }
                        else{
                            $id_d = $edit_d->id_diskusi;
                        }

                        //ACTION
                        $aksi = 0;
                        if($i == 0){
                            $j =1;
                        }
                        else{
                            $j = 0;
                        }
                        
                        $cek = array();
                        if(array_key_exists($i, $action)){
                            // dd(count($action[$i]));
                            if($i == 0 and $action[$i][1]==null){
                                // dd('HEHE');
                                $a = new Action;
                                $a->id_diskusi = $id_d;
                                $a->deskripsi = 'Tidak Ada Action';
                                $a->jenis_action = 'Informasi';
                                $a->email_pic = 'example@email.com';
                                $a->due_date = null;
                                $a->status = 1;
                                $a->save();
                                $aksi++;
                            }
                            else if(count($action[$i]==1 and $action[$i][0]==null)){
                                //dd('HEHE');
                                $a = new Action;
                                $a->id_diskusi = $id_d;
                                $a->deskripsi = 'Tidak Ada Action';
                                $a->jenis_action = 'Informasi';
                                $a->email_pic = 'example@email.com';
                                $a->due_date = null;
                                $a->status = 1;
                                $a->save();
                                $aksi++;
                            }
                            else{
                                foreach($action[$i] as $act){
                                    if(array_key_exists($j, $action[$i])){
                                        if($act!=null){
                                            $edit_a = Action::where('id_diskusi', $id_d)
                                                    ->where('deskripsi', $act)
                                                    ->first();

                                            if($edit_a == null){
                                                //bikin baru
                                                $acti = new Action();
                                                $acti->id_diskusi = $id_d;
                                                $acti->deskripsi = $act;
                                                if($jenis[$i][$j] == 'Target'){
                                                    $acti->jenis_action = 'Target';
                                                    $acti->due_date = $date[$i][$j];
                                                    $acti->email_pic = $pic[$i][$j];
                                                    $acti->status = 0;
                                                }
                                                else{
                                                    $acti->jenis_action = 'Informasi';
                                                    $acti->due_date = null;
                                                    $acti->email_pic = 'example@email.com';
                                                    $acti->status = 1;
                                                }

                                                if($act->save()){
                                                    $aksi++;
                                                    $flag = 1;
                                                }
                                                else{
                                                    $flag = 0;
                                                }

                                            }
                                            else{
                                                //update action
                                                if($jenis[$i][$j] == 'Target'){
                                                    $edit_a->jenis_action = 'Target';
                                                    $edit_a->due_date = $date[$i][$j];
                                                    $edit_a->email_pic = $pic[$i][$j];
                                                    $edit_a->status = 0;
                                                }
                                                else{
                                                    $edit_a->jenis_action = 'Informasi';
                                                    $edit_a->due_date = null;
                                                    $edit_a->email_pic = 'example@email.com';
                                                    $edit_a->status = 1;
                                                }
                                                if($edit_a->save()){
                                                    $aksi++;
                                                    $flag = 1;
                                                }
                                                else{
                                                    $edit_a = 0;
                                                }

                                            }
                                        }
                                    }

                                    if($act!=null){
                                        array_push($cek, $act);
                                    }
                                    
                                    $j++;
                                }
                            }
                        }
                        else{
                            $a = new Action;
                            $a->id_diskusi = $id_d;
                            $a->deskripsi = 'Tidak Ada Action';
                            $a->jenis_action = 'Informasi';
                            $a->email_pic = 'example@email.com';
                            $a->due_date = null;
                            $a->status = 1;
                            $a->save();
                            $aksi++;
                        }

                        if($aksi == 0){
                            $a = new Action;
                            $a->id_diskusi = $id_d;
                            $a->deskripsi = 'Tidak Ada Action';
                            $a->jenis_action = 'Informasi';
                            $a->email_pic = 'example@email.com';
                            $a->due_date = null;
                            $a->status = 1;
                            $a->save();
                        }

                    }

                } 

                if($d!=null){
                    array_push($dis, $d);
                }

                $dba = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $cek)
                        ->get();

                foreach($dba as $h){
                    if($h->delete()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                    }
                }

                $i++;

            }
        }
        
        // dd($aksi);
        // $db = Diskusi::where('id_topik', $id_topik)
        //         ->whereNotIn('nama_diskusi', $dis)
        //         ->get();

        foreach($db as $ha){
            if($ha->delete()){
                $flag = 1;
            }
            else{
                $flag = 0;
            }
        }
        // dd($flag);
    }

    public function destroy(Request $request, $id)
    {
        $del = Topik::find($id);
        $id_agenda = $del->id_agenda;
        $id_rapat = DB::table('agendas')->select('id_rapat')
                    ->where('id_agenda', '=', $id_agenda)->first();

        if($del->delete())
        {
            $request->session()->flash('alert-success', 'Topik berhasil dihapus.');
            return redirect('/agenda/'.$id_rapat->id_rapat);
        }
        else
        {
            $request->session()->flash('alert-danger', 'Topik gagal dihapus.');
            return redirect('/agenda/'.$id_rapat->id_rapat);
        }

    }
}

