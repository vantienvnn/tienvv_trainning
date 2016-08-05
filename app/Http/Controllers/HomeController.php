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
        view()->share('pageTitle', 'Dashboard');
        return view('home');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        view()->share('pageTitle', 'Welcome');
        return view('home');
    }

}
