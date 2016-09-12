<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class WordAnswer extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content', 'word_id', 'correct'
    ];

}
