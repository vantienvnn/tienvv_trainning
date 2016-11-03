<?php

namespace App\Entities;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'facebook_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function getLearnedWords($categoryId = null)
    {
        $wordCount = $this->lessons()
            ->select(\DB::raw('SUM(result) as word_count'))
            ->where(function($query) use ($categoryId){
                if($categoryId){
                    $query->where('category_id', $categoryId);
                }
            })
            ->first();
        if($wordCount){
            return $wordCount->word_count;
        }
        return 0;
    }

}
