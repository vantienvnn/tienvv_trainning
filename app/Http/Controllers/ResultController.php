<?php

namespace App\Http\Controllers;

use App\Repositories\LessonRepository;

class ResultController extends Controller
{

    protected $repository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(LessonRepository $repository)
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
        return redirect('/category');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = $this->repository->find($id);
        $maxQuestionsCount = $this->repository->getMaxQuestionsCount();
        $pageTitle = sprintf('Result %s of %s', $lesson->id, $lesson->category->name);
        return view('result/index', compact([
            'lesson',
            'pageTitle',
            'maxQuestionsCount'
        ]));
    }

}
