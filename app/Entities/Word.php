<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Word extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'category_id'
    ];

    /**
     * Get the word answer for the word.
     */
    public function wordAnswers()
    {
        return $this->hasMany(WordAnswer::class);
    }

    /**
     * Get the word answer for the word.
     */
    public function correctAnswer()
    {
        return $this->hasOne(WordAnswer::class)->where('correct', 1);
    }
    
     /**
     * Get the word answer for the word.
     */
    public function lessonWords()
    {
        return $this->hasMany(LessonWord::class);
    }

}
