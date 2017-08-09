<?php

namespace App\Http\Controllers;

use DB;
use App\Action;
use Illuminate\Http\Request;

class ActionController extends Controller
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
    public function index()
    {
        $action = DB::table('Actions')
                ->join('Diskusis','Actions.id_diskusi','=','Diskusis.id_diskusi')
                ->join('Topiks','Topiks.id_topik','=','Diskusis.id_topik')
                ->join('Agendas','Agendas.id_agenda','=','Topiks.id_agenda')
                ->join('Rapats','Agendas.id_rapat','=','Rapats.id_rapat')
                ->where('Actions.jenis_action','=','Target')
                //->orwhere('Action.solusi','<>','null')
                //->join('Topiks','Topiks.id_topik','=','Diskusis.id_topik')
                ->orderBy('Actions.status','asc')
                ->get();
        //dd($action);
        /*$diskusi = DB::table('Diskusis')
                ->join('Topiks','Topiks.id_topik','=','Diskusis.id_topik')
                ->get();
        $topik = DB::table('Topiks')
                ->join('Agendas','Topiks.id_agenda','=','Agendas.id_agenda')
                ->get();
        $agenda = DB::table('Agendas')
                ->join('Rapats','Rapats.id_rapat','=','Agendas.id_rapat')
                ->get();*/
        //dd($query);
        //dd($action);
        //$act = DB::table('Action')->get();
        return view('target',[/*'diskusi'=>$diskusi*/'action'=>$action/*,'topik'=>$topik,*/
            /*'agenda'=>$agenda*/,'allNotif'=>$this->allNotif]);
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function show(Action $action)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function edit(Action $action)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $edit = Action::where('id_action', $id)->first();
        $id_action = $edit->id_action;
        $deskripsi = $edit->deskripsi;
        $due_date = $edit->due_date;
        $email_pic = $edit->email_pic;
        $edit->status = '1';
        $edit->solusi = $request['solusi'];

        if($edit->save()){
            $request->session()->flash('alert-success', 'Action berhasil diperbarui.');
            return redirect('/action');
        }
        else{
            $request->session()->flash('alert-danger', 'Action gagal diperbarui.');
            return redirect('/action');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Action  $action
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $del = Action::find($id);
        $id_action = $del->id_action;

        if($del->delete())
        {
            $request->session()->flash('alert-success', 'Agenda berhasil dihapus.');
            return redirect('/action');
        }
        else
        {
            $request->session()->flash('alert-danger', 'Agenda gagal dihapus.');
            return redirect ('/action');
        }
    }
    
}
