<?php

namespace App\Repositories\Criterias;

use Prettus\Repository\Contracts\RepositoryInterface;
use Prettus\Repository\Contracts\CriteriaInterface;
use Illuminate\Http\Request;
use App\Entities\LessonWord;

class WordListCriteria implements CriteriaInterface
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        if (($catId = $this->request->input('cat'))) {
            $model = $model->where('category_id', $catId);
        }
        if (($filterBy = $this->request->input('filter'))) {
            $learnedWords = LessonWord::query()
                ->join('lessons', 'lessons.id', '=', 'lesson_words.lesson_id')
                ->where('lessons.user_id', auth()->user()->id)
                ->distinct('lesson_words.word_id')
                ->lists('lesson_words.word_id');
            if ($filterBy == 'learned') {
                $model = $model->whereIn('id', $learnedWords);
            } else {
                $model = $model->whereNotIn('id', $learnedWords);
            }
        }
        return $model;
    }

}
