<?php

namespace App\Http\Controllers;

use App\Rapat;
use Illuminate\Http\Request;
use App\Http\Requests;
use PDF;
use DB;
use Illuminate\Support\Facades\App;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        return view('home');
    }

    public function pdfgen(Request $request)
    {
        $products = DB::table('rapats')->get();
        $pdf=PDF::loadView('pdf-generated', ['products' => $products]);
        return $pdf->stream();
    }

    public function pdf()
    {
        return view ('pdf-generated');
    }
}
