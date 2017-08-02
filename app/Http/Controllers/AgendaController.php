<?php
/**
 * Created by PhpStorm.
 * User: Sabila
 * Date: 8/2/2017
 * Time: 11:16 AM
 */

namespace App\Http\Controllers;


class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda');
    }

}