<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class DashboardController extends Controller
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
        $aaSpots = SpotController::$aaSpotsByLatandLon;
        $name = Auth::user()->name;
        return view('dashboard', compact('aaSpots', 'name'));
    }
}
