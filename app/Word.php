<?php

namespace App;

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

}
