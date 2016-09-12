<?php

namespace App\Http\Controllers;

use App\Repositories\HomeRepository;
use App\Entities\Activity;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $activities = $this->repository->findWhere(array('user_id' => $user->id));
        return view('home', [
            'pageTitle' => 'Home page',
            'learned' => Activity::ACTION_LEARNED,
            'activities' => $activities,
            'learnedWords' => $user->getLearnedWords(),
        ]);
    }

}
