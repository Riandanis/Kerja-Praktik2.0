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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        // dd($id);
        $agenda = new Agenda;
        $agenda->id_rapat = $id;
        $agenda->nama_agenda = $request->input('nama');

        if($agenda->save()){
            $request->session()->flash('alert-success', 'Agenda telah ditambahkan.');
            return redirect('agenda/'.$id, ['allNotif'=>$this->allNotif]);
        }
        else{
            $request->session()->flash('alert-danger', 'Agenda gagal ditambahkan.');
            return redirect('agenda/'.$id, ['allNotif'=>$this->allNotif]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = Agenda::where('id_agenda', $id)->first();
        $id_rapat = $edit->id_rapat;
        $edit->nama_agenda = $request['nama'];

        if($edit->save()){
            $request->session()->flash('alert-success', 'Agenda berhasil diperbarui.');
            return redirect('agenda/'.$id_rapat , ['allNotif'=>$this->allNotif]);
        }
        else{
            $request->session()->flash('alert-danger', 'Agenda gagal diperbarui.');
            return redirect('agenda/'.$id_rapat , ['allNotif'=>$this->allNotif]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Agenda  $agenda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $del = Agenda::find($id);
        $id_rapat = $del->id_rapat;

        if($del->delete())
        {
            $request->session()->flash('alert-success', 'Agenda berhasil dihapus.');
            return redirect('agenda/'.$id_rapat ,['allNotif'=>$this->allNotif]);
        }
        else
        {
            $request->session()->flash('alert-danger', 'Agenda gagal dihapus.');
            return redirect ('agenda/'.$id_rapat , ['allNotif'=>$this->allNotif]);
        }
    }
}
