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
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }
    public function index($rapat, $id)
    {
        //$rapat id_rapat, $id id_agenda
        $topik = DB::table('topiks')->where('id_agenda', '=', $id)->get();
        $agenda = DB::table('agendas')->select('id_agenda', 'id_rapat', 'nama_agenda')
                ->where('id_agenda', '=', $id)->first();

        return view('topik', ['topik'=>$topik, 'agenda'=>$agenda, 'allNotif'=>$this->allNotif]);
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
        return view('create-topik', ['agenda' => $agenda, 'rapat'=>$rapat, 'allNotif'=>$this->allNotif]);
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
    
        //get value from form
        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $pic = $request->input('pic');
        $date = $request->input('due_date');
        
        if($diskusi[0]!=null){
            $top->save();
            
            //get id_topik
            $topik = $top->id_topik;
            
            //insert diskusi
            $i = 0; 
            foreach($diskusi as $dis){
                $d = new Diskusi;
                $d->id_topik = $topik;
                $d->nama_diskusi = $dis;
                
                if($action[$i][0]!=null){
                    $d->save();
                    $id_dis = $d->id_diskusi;
                    $j = 0;
                    $flag = 0;

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
                        
                        if($a->save()){
                            $j++;
                            $flag = 1;
                        }
                        else{
                            $flag = 0;
                            $request->session()->flash('alert-success', 'Action pada diskusi gagal ditambahkan');
                            return redirect('agenda/'.$rapat);
                        }    
                    }

                    if($flag == 1){
                        $request->session()->flash('alert-success', 'Topik rapat, diskusi dan action berhasil ditambahkan.');
                        return redirect('agenda/'.$rapat);
                    }
                }
                else{
                    if($d->save()){
                        $request->session()->flash('alert-success', 'Topik rapat dan diskusi berhasil ditambahkan. Tidak ada dan action yang terdaftar.');
                        return redirect('agenda/'.$rapat);
                    }
                    else{
                        $request->session()->flash('alert-danger', 'Diskusi pada topik gagal ditambahkan.');
                        return redirect('agenda/'.$rapat);
                    }
                }
                $i++;
            }
        }
        else{

            if($top->save()){
                $request->session()->flash('alert-success', 'Topik rapat berhasil ditambahkan. Tidak ada diskusi dan action yang terdaftar.');
                return redirect('agenda/'.$rapat, ['allNotif'=>$this->allNotif]);
            }
            else{
                $request->session()->flash('alert-danger', 'Topik rapat gagal ditambahkan.');
                return redirect('agenda/'.$rapat, ['allNotif'=>$this->allNotif]);
            }
        }
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
        return view('edit-topik', ['topik'=>$topik]);
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

