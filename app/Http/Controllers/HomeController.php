<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Activity;

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
        $learnedWords = 0;
        $activities = Activity::getByAuthUser();
        return view('home', [
            'pageTitle' => 'Dashboard',
            'learnedWords' => $learnedWords,
            'activities' => $activities
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        if (auth()->check()) {
            return redirect('home');
        }
        return view('welcome', ['pageTitle' => 'Welcome']);
    }

}
