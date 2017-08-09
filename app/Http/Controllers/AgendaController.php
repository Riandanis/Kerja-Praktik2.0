<?php

namespace App\Http\Controllers;

use DB;
use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class AgendaController extends Controller
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
    public function index($id)
    {
        $rapat = DB::table('rapats')->select('id_rapat', 'headline')
            ->where('rapats.id_rapat', '=', $id)->first();
        $agenda = DB::table('agendas')->where('agendas.id_rapat', '=', $id)
            ->get();
        return view('agenda', ['agenda'=>$agenda, 'rapat'=>$rapat,'allNotif'=>$this->allNotif]);
    }

    public function renderTopik() {
        $id_agenda = Input::get('q');
        $topik = DB::table('topiks')->where('id_agenda', '=', $id_agenda)->get();
        return json_encode($topik);
    }

    public function store(Request $request, $id)
    {
        $agenda = new Agenda;
        $agenda->id_rapat = $id;
        $agenda->nama_agenda = $request->input('nama');

        if($agenda->save()){
            $request->session()->flash('alert-success', 'Agenda telah ditambahkan.');
            return redirect('agenda/'.$id);
        }
        else{
            $request->session()->flash('alert-danger', 'Agenda gagal ditambahkan.');
            return redirect('agenda/'.$id);
        }
    }

    public function update(Request $request, $id)
    {
        $edit = Agenda::where('id_agenda', $id)->first();
        $id_rapat = $edit->id_rapat;
        $edit->nama_agenda = $request['nama'];

        if($edit->save()){
            $request->session()->flash('alert-success', 'Agenda berhasil diperbarui.');
            return redirect('agenda/'.$id_rapat);
        }
        else{
            $request->session()->flash('alert-danger', 'Agenda gagal diperbarui.');
            return redirect('agenda/'.$id_rapat);
        }
    }

    public function destroy(Request $request, $id)
    {
        $del = Agenda::find($id);
        $id_rapat = $del->id_rapat;

        if($del->delete())
        {
            $request->session()->flash('alert-success', 'Agenda berhasil dihapus.');
            return redirect('agenda/'.$id_rapat);
        }
        else
        {
            $request->session()->flash('alert-danger', 'Agenda gagal dihapus.');
            return redirect ('agenda/'.$id_rapat );
        }
    }
}