<?php

namespace App\Entities;

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
    
    public function words()
    {
        return $this->hasMany(Word::class);
    }
    
    public function getWordsCount()
    {
        return $this->words()->count();
    }
    
    public function getWordsList()
    {
        return $this->words()->lists('content', 'id')
            ->toArray();
    }

}
