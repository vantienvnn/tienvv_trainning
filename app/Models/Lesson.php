<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Lesson extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id', 'result'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getLearnedWordIds()
    {
        $learnedWordIds = LessonWord::query()->
        where('lesson_id', $this->id)
        ->lists('word_id')->toArray();
        return array_values($learnedWordIds);
    }

    public function getLearnedWords()
    {
        return LessonWord::query()
        ->where('lesson_id', $this->id)->get();
    }

    public function getNextQuestion()
    {
        $learnedWordIds = $this->getLearnedWordIds();
        $wordQuery = Word::query()->where('category_id', $this->category_id);
        if ($learnedWordIds) {
            $wordQuery->whereNotIn('id', $learnedWordIds);
        }
        $learnedCount = count($learnedWordIds);
        $word = $wordQuery->orderBy(\DB::raw('RAND()'))->first();
        return [$word, $learnedCount];
    }

    public function saveAnswer(Request $request)
    {
        $lessonWord = new LessonWord([
            'lesson_id' => $this->id,
            'word_id' => $request->input('word_id'),
            'word_answer_id' => $request->input('answer')
        ]);
        $lessonWord->save();
        if (count($this->getLearnedWordIds()) == static::getMaxQuestionsCount()) {
            $this->result = true;
            $this->save();
            $activity = new Activity([
                'action_type' => Activity::ACTION_LEARNED,
                'user_id' => auth()->user()->id,
                'target_id' => $this->id,
            ]);
            $activity->save();
        }
        return $lessonWord;
    }

    public function isFinished()
    {
        return !empty($this->result);
    }

    public static function startLesson($categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $lesson = new static([
            'user_id' => auth()->user()->id,
            'category_id' => $category->id,
            'result' => 0
        ]);
        $lesson->save();
        return $lesson;
    }

    public static function getMaxQuestionsCount()
    {
        return env('LESSON_MAX_QUESTION', 5);
    }

}
