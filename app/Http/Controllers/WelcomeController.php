<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->check()) {
            return redirect('/home');
        }
        return view('welcome', [
            'pageTitle' => 'Welcome'
        ]);
    }

}
