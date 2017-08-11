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
        $flag = 0;
        //insert topik
        $top = new Topik();
        $top->id_agenda = $id;
        $top->nama_topik = $request->input('topik');
        if($top->save()){
            $flag = 1;
        }
        else{
            $flag = 0;
            $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
            return redirect('agenda/'.$rapat);
        }

        //get id_topik
        $topik = $top->id_topik;

        //get value from form
        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $pic = $request->input('pic');
        $date = $request->input('due_date');

        $jml_d = 0;
        $jml_a = 0;
        foreach($diskusi as $d){
            if($d!=null){
                $disk = new Diskusi();
                $disk->id_topik = $topik;
                $disk->nama_diskusi = $d;
                if($disk->save()){
                    $flag = 1;
                }
                else{
                    $flag = 0;
                    $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
                    return redirect('agenda/'.$rapat);
                }
                $id_dis = $disk->id_diskusi;

                //ACTION
                $i = array_search($d, $diskusi);
                $jml_a = 0;

                if(array_key_exists($i, $action)){
                    foreach($action[$i] as $act){
                        if($act!=null){
                            $j = array_search($act, $action[$i]);
                            $aksi = new Action();
                            $aksi->id_diskusi = $id_dis;
                            $aksi->deskripsi = $act;
                            if($jenis[$i][$j]=='Target'){
                                $aksi->jenis_action = 'Target';
                                $aksi->email_pic = $pic[$i][$j];
                                $aksi->due_date = $date[$i][$j];
                                $aksi->status = 0;
                            }
                            else{
                                $aksi->jenis_action = 'Informasi';
                                $aksi->email_pic = 'example@email.com';
                                $aksi->due_date = null;
                                $aksi->status = 1;
                            }
                            
                            if($aksi->save()){
                                $flag = 1;
                            }
                            else{
                                $flag = 0;
                                $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
                                return redirect('agenda/'.$rapat);
                            }
                            $jml_a++;
                        }
                    }
                }

                if($jml_a == 0){
                    $baru = new Action();
                    $baru->id_diskusi = $id_dis;
                    $baru->deskripsi = 'Tidak Ada Action';
                    $baru->jenis_action = 'Informasi';
                    $baru->email_pic = 'example@email.com';
                    $baru->due_date = null;
                    $baru->status = 1;
                    if($baru->save()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                        $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
                        return redirect('agenda/'.$rapat);
                    }
                }
                $jml_d++;
            }
        }

        if($jml_d==0){
            $new = new Diskusi();
            $new->id_topik = $topik;
            $new->nama_diskusi = 'Tida Ada Diskusi';
            if($new->save()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
                return redirect('agenda/'.$rapat);
            }

            $id_d = $new->id_diskusi;
            $acti = new Action();
            $acti->id_diskusi = $id_d;
            $acti->deskripsi = 'Tidak Ada Action';
            $acti->jenis_action = 'Informasi';
            $acti->email_pic = 'example@email.com';
            $acti->due_date = null;
            $acti->status = 1;
            if($acti->save()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal ditambahkan.');
                return redirect('agenda/'.$rapat);
            }
        }

        if($flag ==1){
            $request->session()->flash('alert-success', 'Topik berhasil ditambahkan.');
            return redirect('agenda/'.$rapat);
        }
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
        //ALERT
        if($edit_top->save()){
            $flag = 1;
        }
        else{
            $flag = 0;
            $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
            return redirect('/topik/edit/'.$id);
        }
        $id_topik = $id;

        $diskusi = $request->input('diskusi');
        $action = $request->input('action');
        $jenis = $request->input('keterangan');
        $email_pic = $request->input('pic');
        $date = $request->input('due_date');

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
                    //ALERT
                    if($dis->save()){
                        $flag = 1;
                        $id_d = $dis->id_diskusi;
                    }
                    else{
                        $flag = 0;
                        $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                        return redirect('/topik/edit/'.$id);
                    }
                }
                else{
                    $id_d = $cek->id_diskusi;
                }

                array_push($hapus_diskusi, $d);
                $jml_d++;

                
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
                                
                                //ALERT
                                if($aksi->save()){
                                    $flag = 1;
                                }
                                else{
                                    $flag = 0;
                                    $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                                    return redirect('/topik/edit/'.$id);
                                }
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

                                //ALERT
                                if($cek_a->save()){
                                    $flag = 1;
                                }
                                else{
                                    $flag = 0;
                                    $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                                    return redirect('/topik/edit/'.$id);
                                }
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
                    //ALERT
                    if($hap->delete()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                        $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                        return redirect('/topik/edit/'.$id);
                    }
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
                    //ALERT
                    if($eksyen->save()){
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

        $db_d = Diskusi::where('id_topik', $id_topik)
                ->whereNotIn('nama_diskusi', $hapus_diskusi)
                ->get();

        foreach($db_d as $hapus){
            //ALERT
            if($hapus->delete()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                return redirect('/topik/edit/'.$id);
            }
        }

        if($jml_d==0  && $jml_a==0){
            //Tidak ada Diskusi & Action
            $disc = new Diskusi();
            $disc->id_topik = $id_topik;
            $disc->nama_diskusi = 'Tidak Ada Diskusi';
            //ALERT
            if($disc->save()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                return redirect('/topik/edit/'.$id);
            }
            $id_disc = $disc->id_diskusi;

            $acti = new Action();
            $acti->id_diskusi = $id_disc;
            $acti->deskripsi = 'Tidak Ada Action';
            $acti->due_date = null;
            $acti->email_pic = 'example@email.com';
            $acti->jenis_action = 'Informasi';
            $acti->status = 1;
            //ALERT
            if($acti->save()){
                $flag = 1;
            }
            else{
                $flag = 0;
                $request->session()->flash('alert-danger', 'Topik gagal diperbarui.');
                return redirect('/topik/edit/'.$id);
            }
        }

        //ALERT
        if($flag == 1){
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

