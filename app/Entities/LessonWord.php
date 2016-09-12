<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class LessonWord extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lesson_id', 'word_id', 'word_answer_id'
    ];

    public function word()
    {
        return $this->belongsTo(Word::class);
    }
    
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function wordAnswer()
    {
        return $this->belongsTo(WordAnswer::class);
    }
    
    public function isCorrectAnswer()
    {
        return $this->word_answer_id == $this->word->correctAnswer->id;
    }

}
