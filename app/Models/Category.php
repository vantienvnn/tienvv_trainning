<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * Get words count of this category
     * @return int
     */
    public function wordsCount()
    {
        return Word::query()
        ->where('category_id', $this->id)
        ->count();
    }

    /**
     * Get learned words of this category and current logged user
     */
    public function learnedCount()
    {
        return WordAnswer::query()
        ->where('word_id', $this->id)
        ->where('correct', 1)
        ->count();
    }

    public function wordsList()
    {
        return Word::query()
        ->where('category_id', $this->id)
        ->lists('content', 'id')
        ->toArray();
    }

}
