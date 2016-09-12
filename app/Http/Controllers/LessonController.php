<?php

namespace App\Http\Controllers;

use App\Repositories\LessonRepository;
use Illuminate\Http\Request;

class LessonController extends Controller
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
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = $this->repository->find($id);
        if ($this->repository->isFinished($lesson)) {
            return redirect('result/' . $lesson->id);
        }
        $result = $this->repository->getQuestion($lesson);
        if (empty($result)) {
            return redirect('/category');
        }
        extract($result);
        $pageTitle = sprintf('Lesson %s of %s', $lesson->id, $lesson->category->name);
        return view('lesson/index', compact([
            'lesson',
            'learnedCount',
            'word',
            'pageTitle',
            'maxQuestionsCount'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryId = $request->input('category_id');
        $lesson = $this->repository->startLesson($categoryId);
        return redirect('lesson/' . $lesson->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $lesson = $this->repository->find($id);
        $this->repository->saveAnswer(
            $lesson, 
            $request->input('word_id'), 
            $request->input('answer_id')
        );
        if ($this->repository->isFinished($lesson)) {
            return redirect('result/' . $lesson->id);
        }
        return redirect('lesson/' . $lesson->id);
    }

}
