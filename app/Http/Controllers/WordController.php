<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Models\Word;
use App\Models\WordAnswer;
use App\Models\Category;
use Validator;
use Illuminate\Http\Request;

class WordController extends Controller
{

    protected function getWordQueryBuilder()
    {
        
    }

    /**
     * The welcome board
     *
     * @return \Illuminate\Http\Response
     */
    public function getIndex(Request $request)
    {
        $categories = array('--Select--') + Category::lists('name', 'id')->toArray();
        $query = Word::query();
        if ($request->input('cat')) {
            $query->where('category_id', intval($request->input('cat')));
        }
        $words = $query->get();
        return view('word/index', [
            'categories' => $categories,
            'words' => $words,
            'pageTitle' => 'Word List',
            'request' => $request
        ]);
    }

    /**
     * Get a validator for an incoming create/update request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'content' => 'required|max:255',
            'answer.1' => 'required|max:255',
            'answer.2' => 'required|max:255',
            'answer.3' => 'required|max:255',
            'answer.4' => 'required|max:255',
            'correct' => 'required|in:1,2,3,4',
            'category_id' => 'required|exists:categories,id'
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function postAdd(Request $request)
    {
        $data = $request->all();
        $validator = $this->validator($data);
        if ($validator->fails()) {
            $this->throwValidationException(
            $request, $validator
            );
        }
        $answers = $data['answer'];
        unset($data['answer']);
        $word = new Word($data);
        $word->save();
        foreach ($answers as $idx => $answer) {
            $wordAnswer = new WordAnswer(array(
                'word_id' => $word->id,
                'content' => $answer,
                'correct' => ($data['correct'] == $idx)
            ));
            $wordAnswer->save();
        }
        $request->session()->flash('alert-success', 'Successfully saved.');
        return redirect('word');
    }

}
