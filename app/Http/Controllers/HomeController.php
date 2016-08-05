<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'welcome']);
    }

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', ['pageTitle' => 'Dashboard']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        return view('welcome', ['pageTitle' => 'Welcome']);
    }

}
