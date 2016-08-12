<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    
    const TOTAL_QUESTIONS = 20;
    
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

}
