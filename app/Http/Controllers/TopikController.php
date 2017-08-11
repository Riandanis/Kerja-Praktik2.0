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
        $topik = DB::table('topiks')->where('id_topik', '=', $id)->first();
        $agenda = $topik->id_agenda;
        $rpt = DB::table('agendas')->where('id_agenda', '=', $agenda)->first();
        $rapat = $rpt->id_rapat;
        // dd($rapat);

        return view('edit-topik', ['topik'=>$topik, 'rapat'=>$rapat, 'id'=>$id,'allNotif'=>$this->allNotif]);
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

        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $email_pic = $request->input('pic');
        $date = $request->input('due_date');

        // dd($diskusi);
        // dd($id_topik, $diskusi, $action, $jenis, $email_pic, $date);
        $flag = 0;
        $jml_d = 0;
        $jml_a = 0;
        $hapus_diskusi = array();
        foreach($diskusi as $d){
            if($d!=null){
                $cek = Diskusi::where('id_topik', $id_topik)
                        ->where('nama_diskusi', $d)->first();

                if($cek == null){
                    //bikin baru
                    $dis = new Diskusi;
                    $dis->id_topik = $id_topik;
                    $dis->nama_diskusi = $d;
                    if($dis->save()){
                        $flag = 1;
                        $id_d = $dis->id_diskusi;
                    }
                    else{
                        $flag = 0;
                    }
                }
                else{
                    $id_d = $cek->id_diskusi;
                }

                array_push($hapus_diskusi, $d);
                $jml_d++;

                // dd($diskusi, $i);
                
                //ACTION
                $i = array_search($d, $diskusi);
                $hapus_action = array();
                $jml_a = 0;

                if(array_key_exists($i, $action)){
                    foreach($action[$i] as $act){
                        if($act!=null){
                            $cek_a = Action::where('id_diskusi', $id_d)
                                    ->where('deskripsi', $act)->first();
                            $j = array_search($act, $action[$i]);

                            if($cek_a == null){
                                //bikin baru
                                $aksi = new Action();
                                $aksi->id_diskusi = $id_d;
                                $aksi->deskripsi = $act;
                                if($jenis[$i][$j]=='Target'){
                                    $aksi->jenis_action = 'Target';
                                    $aksi->email_pic = $email_pic[$i][$j];
                                    $aksi->due_date = $date[$i][$j];
                                    $aksi->status = 0;
                                }
                                else{
                                    $aksi->jenis_action = 'Informasi';
                                    $aksi->email_pic = 'example@email.com';
                                    $aksi->due_date = null;
                                    $aksi->status = 1;
                                }
                                $aksi->save();
                            }
                            else{
                                //edit
                                $cek_a->deskripsi = $act;
                                if($jenis[$i][$j]=='Target'){
                                    $cek_a->jenis_action = 'Target';
                                    $cek_a->email_pic = $email_pic[$i][$j];
                                    $cek_a->due_date = $date[$i][$j];
                                    $cek_a->status = 0;
                                }
                                else{
                                    $cek_a->jenis_action = 'Informasi';
                                    $cek_a->email_pic = 'example@email.com';
                                    $cek_a->due_date = null;
                                    $cek_a->status = 1;
                                }
                                $cek_a->save();
                            }

                            array_push($hapus_action, $act);
                            $jml_a++;
                        }
                    }
                }

                

                $db_a = Action::where('id_diskusi', $id_d)
                        ->whereNotIn('deskripsi', $hapus_action)
                        ->get();

                foreach($db_a as $hap){
                    $hap->delete();
                }

                if($jml_a==0){
                    //Tidak Ada Action
                    $eksyen = new Action();
                    $eksyen->id_diskusi = $id_d;
                    $eksyen->deskripsi = 'Tidak Ada Action';
                    $eksyen->due_date = null;
                    $eksyen->email_pic = 'example@email.com';
                    $eksyen->jenis_action = 'Informasi';
                    $eksyen->status = 1;
                    $eksyen->save();
                }
            }
        }

        $db_d = Diskusi::where('id_topik', $id_topik)
                ->whereNotIn('nama_diskusi', $hapus_diskusi)
                ->get();

        foreach($db_d as $hapus){
            $hapus->delete();
        }

        if($jml_d==0  && $jml_a==0){
            //Tidak ada Diskusi & Action
            $disc = new Diskusi();
            $disc->id_topik = $id_topik;
            $disc->nama_diskusi = 'Tidak Ada Diskusi';
            $disc->save();
            $id_disc = $disc->id_diskusi;
            // dd($id_disc);

            $acti = new Action();
            $acti->id_diskusi = $id_disc;
            $acti->deskripsi = 'Tidak Ada Action';
            $acti->due_date = null;
            $acti->email_pic = 'example@email.com';
            $acti->jenis_action = 'Informasi';
            $acti->status = 1;
            $acti->save();
        }
        
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

