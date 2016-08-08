<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lesson;

class LessonController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('category');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $lesson = Lesson::startLesson($request->input('category_id'));
        return redirect('lesson/' . $lesson->id);
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
        $lesson = Lesson::findOrFail($id);
        if ($lesson->isFinished()) {
            return redirect('lesson/result/' . $lesson->id);
        }
        list($word, $learnedCount) = $lesson->getNextQuestion();
        if (empty($word)) {
            session()->flash('alert-danger', 'The lesson can not be continue because out of words.');
            return redirect('category');
        }
        $maxQuestionsCount = Lesson::getMaxQuestionsCount();
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $lesson = Lesson::findOrFail($id);
        $lesson->saveAnswer($request);
        if ($lesson->isFinished()) {
            return redirect('result/' . $lesson->id);
        }
        return redirect('lesson/' . $lesson->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
