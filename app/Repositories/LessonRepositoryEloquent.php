<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Entities\Lesson;
use App\Entities\Category;
use App\Entities\Word;
use App\Entities\WordAnswer;
use App\Entities\Activity;
use App\Entities\LessonWord;

/**
 * Class HomeRepositoryEloquent
 * @package namespace App\Repositories;
 */
class LessonRepositoryEloquent extends BaseRepository implements LessonRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Lesson::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function startLesson($categoryId){
        $category = Category::findOrFail($categoryId);
        return $this->create([
            'user_id' => auth()->user()->id,
            'category_id' => $category->id,
            'result' => 0
        ]);
    }
    
    public function getQuestion(Lesson $lesson)
    {
        $learnedWordIds = $lesson->getLearnedWordIds();
        $wordQuery = Word::query()->where('category_id', $lesson->category_id);
        if (!empty($learnedWordIds)) {
            $wordQuery->whereNotIn('id', $learnedWordIds);
        }
        $learnedCount = count($learnedWordIds);
        $maxQuestionsCount = $this->getMaxQuestionsCount();
        if($learnedCount == $maxQuestionsCount){
            return false;
        }
        $word = $wordQuery->orderBy(\DB::raw('RAND()'))->first();
        if(empty($word)){
            return false;
        }
        return compact([
            'lesson',
            'word',
            'learnedCount',
            'maxQuestionsCount'
        ]);
    }
    
    public function isFinished(Lesson $lesson){
        return count($lesson->getLearnedWordIds()) == $this->getMaxQuestionsCount();
    }

    public function saveAnswer(Lesson $lesson , $wordId , $wordAnswerId){
        $word = Word::findOrFail($wordId);
        $wordAnswer = WordAnswer::findOrFail($wordAnswerId);
        $lessonWord = new LessonWord([
            'lesson_id' => $lesson->id,
            'word_id' => $word->id,
            'word_answer_id' => $wordAnswer->id
        ]);
        if($word->correctAnswer->id == $wordAnswer->id){
            $lesson->result ++;
            $lesson->save();
        }
        $lessonWord->save();
        if ($this->isFinished($lesson)) {
            $activity = new Activity([
                'action_type' => Activity::ACTION_LEARNED,
                'user_id' => auth()->user()->id,
                'target_id' => $lesson->id,
            ]);
            $activity->save();
        }
        return $lessonWord;
    }

    public function getMaxQuestionsCount(){
        return env('APP_MAX_QUESTION' , 20);
    }

}
