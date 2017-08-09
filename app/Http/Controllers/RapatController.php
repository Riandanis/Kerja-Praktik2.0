<?php

namespace App\Http\Controllers;

use DB;
use App\Rapat;
use App\Attendee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class RapatController extends Controller
{
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }
    public function index()
    {
        $rapat = DB::table('rapats')->orderBy('id_rapat')->paginate(25);
        return view('home', ['rapat'=>$rapat,'allNotif'=>$this->allNotif]);
    }


    public function rapat()
    {
        $rapat = DB::table('rapats')->orderBy('id_rapat')->paginate(25);
        return view('rapat', ['rapat'=>$rapat,'allNotif'=>$this->allNotif]);
    }

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

   
    public function store(Request $request)
    {
        $tanggal = $request->input('tanggal_rapat');
        $jam = $request->input('waktu_rapat');
        $waktu = $tanggal . " " . $jam;

        $rapat = new Rapat();
        $rapat->headline = $request->input('headline');
        $rapat->waktu_rapat = $waktu;
        $rapat->tempat_rapat = $request->input('tempat');
        
        $peserta = $request->input('peserta');

        if($peserta[0]!=null){
            $flag = 0;
            $rapat->save();
            $id = $rapat->id_rapat;
            foreach($peserta as $p){
                $pes = new Attendee();
                $pes->id_rapat = $id;
                $pes->ket_attendee = $p;
                if($pes->save()){
                    $flag = 1;
                }
                else{
                    $flag = 0;
                    $request->session()->flash('alert-danger', 'Rapat gagal ditambahkan.');
                    return redirect('/home');
                }
            }
            if($flag == 1){
                $request->session()->flash('alert-success', 'Rapat berhasil ditambahkan.');
                return redirect('/home');
            }
        }
        else{
            if($rapat->save()){
                $request->session()->flash('alert-success', 'Rapat berhasil ditambahkan. Belum ada peserta rapat yang terdaftar.');
                return redirect('/home');
            }
            else{
                $request->session()->flash('alert-danger', 'Rapat gagal ditambahkan.');
                return redirect('/home');
            }
        }
    }

    public function edit($rapat)
    {   
        //dd($rapat);
        $rpt = Rapat::where('id_rapat',$rapat)->first();
        $wkt = explode(' ',$rpt->waktu_rapat);
        //dd($wkt);
        $atd = Attendee::where('id_rapat',$rapat)->get();
        //dd(count($atd));
        return view('edit-rapat',['allNotif'=>$this->allNotif,'rpt'=>$rpt,'atd'=>$atd,
            'wkt'=>$wkt]);

    }
     public function getRapat ()
     {
        $id_rapat = Input::get('idrapat');

        $attendee = DB::select("SELECT Attendees.ket_attendee FROM Attendees WHERE
            Attendees.id_rapat = '".$id_rapat."' ");
        return json_encode($attendee);
     }

    public function update(Request $request, $rapat)
    {   
        //$rpt = DB::table('Rapats')->where('Rapats.id_rapat','=',$rapat)->first();
        $atd = DB::table('Attendees')->where('Attendees.id_rapat','=',$rapat)->delete();
        $rpt = Rapat::where('id_rapat',$rapat)->first(); 
        //dd($rpt);
        $tanggal = $request->input('tanggal_rapat');
        $jam = $request->input('waktu_rapat');
        $waktu = $tanggal . " " . $jam;

        $rpt->headline = $request->input('headline');
        $rpt->waktu_rapat = $waktu;
        $rpt->tempat_rapat = $request->input('tempat');
        $rpt->save();
        $id = $rpt->id_rapat;        

        $peserta = $request->input('peserta');

        $flag = 0;
        $i = 0;
        foreach($peserta as $p){
            if(array_key_exists($i, $peserta)){
                if($p!=null){
                    $pes = new Attendee();
                    $pes->id_rapat = $id;
                    $pes->ket_attendee = $p;
                    if($pes->save()){
                        $flag = 1;
                    }
                    else{
                        $flag = 0;
                        $request->session()->flash('alert-danger', 'Rapat gagal diperbarui.');
                        return redirect('/rapat/edit/'.$rpt->id_rapat);
                    }    
                }
            }
            $i++;
        }
        
        if($flag == 1){
            $request->session()->flash('alert-success', 'Rapat berhasil diperbarui.');
            return redirect('/rapat/edit/'.$rpt->id_rapat);
        }
        
    }
}
