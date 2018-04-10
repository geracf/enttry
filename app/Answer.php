<?php

namespace App;

use App\Question;
use App\Student\Application;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
