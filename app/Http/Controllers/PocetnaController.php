<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PocetnaController extends Controller
{

    //  public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $putovanja = \App\Models\Putovanje::all();
        return view('pocetna', compact('putovanja'));
    }
}
