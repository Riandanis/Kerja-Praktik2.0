<?php
/**
 * Created by PhpStorm.
 * User: Sabila
 * Date: 8/2/2017
 * Time: 1:58 PM
 */

namespace App\Http\Controllers;


class TopikController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        return view('create-topik');
    }
}