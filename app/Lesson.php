<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

}
