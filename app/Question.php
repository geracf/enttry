<?php

namespace App;

use App\Answer;
use App\Offer;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function (Question $question) {
            if ($question->answers) {
                $question->answers()->delete();
            }
        });
    }
}
