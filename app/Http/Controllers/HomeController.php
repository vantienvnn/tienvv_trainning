<?php

namespace App\Http\Controllers;

use \App\Activity;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\Criterias\UserActivityCriteria;
use App\Repositories\HomeRepository;

class HomeController extends Controller
{

    /**
     * @var PostRepository
     */
    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(HomeRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new UserActivityCriteria());
        $this->middleware('auth', ['except' => 'welcome']);
    }

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = $this->repository->paginate($limit = null);
        $user = auth()->user();
        return view('home', [
            'pageTitle' => 'Dashboard',
            'activities' => $paginate->all(),
            'learnedWords' => 0,
            'learned' => Activity::ACTION_LEARNED,
            'user' => $user
        ]);
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
