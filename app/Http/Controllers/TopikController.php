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
        dd($diskusi);
        //foreach($diskusi as $d)




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

