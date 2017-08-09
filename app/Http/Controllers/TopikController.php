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

                if($action[$i][0]!=null){
                    $j = 0;

                    //insert action
                    foreach($action[$i] as $act){
                        $a = new Action;
                        $a->id_diskusi = $id_dis;
                        $a->deskripsi = $act;
                        $a->due_date = $date[$i][$j];

                        if($jenis[$i][$j] == 'Target'){
                            $a->status = 0;
                            $a->jenis_action = 'Target';
                            $a->email_pic = $pic[$i][$j];
                        }
                        else{
                            $a->status = 1;
                            $a->jenis_action = 'Informasi';
                            $a->email_pic = 'email@email';
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
                    $a->email_pic = 'email@email';
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
            $a->email_pic = 'email@email';
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
        
        $i = 0;
        $j = 0;
        $flag = 0;

        foreach($diskusi as $d){
            if($d!=null){
                $edit_d = Diskusi::where('nama_diskusi', $d)
                            ->where('id_topik', $id)->first();
                if($edit_d==null){
                    //bikin baru
                    $baru = new Diskusi();
                    $baru->id_topik = $id;
                    $baru->nama_diskusi = $d;
                    if($baru->save()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                    }
                    $id_d = $baru->id_diskusi;
                }
                else{
                    $id_d = $edit_d->id_diskusi;
                }

                //ACTION
                $j = 0;
                $cek = array();
                foreach($action[$i] as $act){
                    if(array_key_exists($j, $action[$i])){
                        $tgl = $date[$i][$j];
                        $imel = $pic[$i][$j];
                        $jns = $jenis[$i][$j];    
                        if($act!=null){
                            $edit_a = Action::where('deskripsi', $act)
                                        ->where('id_diskusi', $id_d)
                                        ->first();
                            
                            if($edit_a==null){
                                //bikin baru
                                $new = new Action();
                                $new->id_diskusi = $id_d;
                                $new->deskripsi = $act;
                                $new->due_date = $tgl;
                                // $new->email_pic = $imel;

                                if($jns == 'Target'){
                                    $new->jenis_action = 'Target';
                                    $new->email_pic = $imel;
                                    $new->status = 0;
                                }
                                else{
                                    $new->jenis_action = 'Informasi';
                                    $new->email_pic = 'email@email';
                                    $new->status = 1;
                                }

                                if($new->save()){
                                    $flag = 1;
                                }
                                else{
                                    $flag = 0;
                                    $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                                    return redirect('/topik/edit/'.$id);
                                }
                                
                            }
                            else{
                                //update action
                                $edit_a->due_date = $tgl;
                                $edit_a->jenis_action = $jns;

                                if($jns == 'Target'){
                                    $edit_a->status = 0;
                                    $edit_a->email_pic = $imel;
                                    $edit_a->jenis_action = 'Target';
                                }
                                else{
                                    $edit_a->status = 1;
                                    $edit_a->email_pic = 'email@email';
                                    $edit_a->jenis_action = 'Informasi';
                                }
                              
                                if($edit_a->save()){
                                    $flag = 1;
                                }
                                else{
                                    $flag = 0;
                                    $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                                    return redirect('/topik/edit/'.$id);
                                } 

                            }

                        }
                    }
                    if($act!=null){
                        array_push($cek, $act);    
                    }
                    
                    $j++;       
                    
                }
                
                $dba = Action::whereNotIn('deskripsi', $cek)
                        ->where('id_diskusi', $id_d)
                        ->get();
                        
                foreach($dba as $ha){
                    if($ha->delete()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                        $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                        return redirect('/topik/edit/'.$id);
                    }
                }
            }

            $i++;
            
        }

        $db = Diskusi::where('id_topik', $id)
                ->whereNotIn('nama_diskusi', $diskusi)
                ->get();
        foreach($db as $hapus){
            if($hapus->delete()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                return redirect('/topik/edit/'.$id);
            }
        }

        if($flag==1){
            $request->session()->flash('alert-success', 'Topik berhasil diperbarui.');
            return redirect('/topik/edit/'.$id);
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

