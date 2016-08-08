<?php

namespace App\Models;

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
    public function answers()
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

}
