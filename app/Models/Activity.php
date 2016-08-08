<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    const ACTION_LEARNED = 'learned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'action_type', 'user_id', 'target_id'
    ];

    public static function getByAuthUser()
    {
        return static::query()->where('user_id', auth()->user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
    }

    public function target()
    {
        switch ($this->action_type) {
            case static::ACTION_LEARNED:
                return $this->belongsTo(Lesson::class, 'target_id');
        }
    }

}
