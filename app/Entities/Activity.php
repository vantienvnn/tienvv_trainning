<?php

namespace App\Entities;

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

    public function target()
    {
        switch ($this->action_type) {
            case static::ACTION_LEARNED:
                return $this->belongsTo(Lesson::class, 'target_id');
            default:
                throw new \Exception(sprintf('Missing case for %s', $this->action_type));
        }
    }

}
