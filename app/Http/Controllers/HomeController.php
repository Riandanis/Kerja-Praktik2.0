<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $allNotif;
    public function __construct()
    {
        $this->allNotif = DB::select("SELECT * FROM actions WHERE actions.status = '0'");   
    }
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home',['allNotif'=>$this->allNotif]);
    }

    public function pdf()
    {
        return view('pdf',['allNotif'=>$this->allNotif]);
    }

    public function pdfgen()
    {
        return view ('pdf-generated',['allNotif'=>$this->allNotif]);
    }
}
